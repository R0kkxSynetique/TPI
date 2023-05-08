<?php

namespace App\Http\Controllers;

use App\Models\Battery;
use App\Models\Engine;
use App\Models\Flights;
use App\Models\Propeller;
use App\Models\RcModel;
use App\Models\Transmitter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\AssignOp\Concat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class RcModelController extends Controller
{
    /**
     * Display a listing of the logged in user rc models.
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia("Homepage", [
            'rc-models' => RcModel::with(['engines', 'batteries', 'transmitter'])->where('user_id', "=", Auth::user()->id)->get(),
        ]);
    }

    /**
     * Show the form to create a new rc model.
     * @return \Inertia\Response
     */
    public function create()
    {
        return inertia("RcModelCreation", [
            'transmitters' => Transmitter::all(),
            'engines' => Engine::all(),
            'propellers' => Propeller::all(),
            'batteries' => Battery::all(),
        ]);
    }

    /**
     * Store a newly created rc model in Database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // * Validation of the image
        request()->validate([
            'image' => [
                'required',
                File::image()
                    ->max(12 * 1024)
            ]
        ]);

        // * Getting the rc model data from the request
        $input = collect(request()->get('rcModel'));

        // * Replacing the user id placeholder in the rc model
        $input->put('user_id', Auth::user()->id);

        // * Adding the transmitter id to the rc model
        if ($input->get('transmitter') != null) {
            $input->put('transmitter_id', $input->get('transmitter')['id']);
        }

        // * Creating the rc model in the database
        $rcModel = DB::transaction(function () use ($input) {
            $rcModel = RcModel::create($input->only([
                'name',
                'manufacturer',
                'description',
                'wingSpan',
                'weight',
                'length',
                'height',
                'acquired_on',
                'finished_on',
                'first_flown_on',
                'flights_offset',
                'user_id',
                'transmitter_id',
            ])->toArray());
            // * Adding the engines, propellers and batteries to the rc model
            $engines = collect($input->get('engines'));
            $rcModel->engines()->sync(
                $engines->mapWithKeys(fn ($engine) => [$engine['id'] => ['quantity' => $engine['pivot']['quantity']]])
            );
            $propellers = collect($input->get('propellers'));
            $rcModel->propellers()->sync(
                $propellers->mapWithKeys(fn ($propeller) => [$propeller['id'] => ['quantity' => $propeller['pivot']['quantity']]])
            );
            $batteries = collect($input->get('batteries'));
            $rcModel->batteries()->sync(
                $batteries->mapWithKeys(fn ($battery) => [$battery['id'] => ['quantity' => $battery['pivot']['quantity']]])
            );
            return $rcModel;
        });

        // * Storing the image named after the rc model id
        request()->file('image')->storeAs("RcModelsImages", $rcModel->id . ".jpg");

        // * Redirecting to the "homepage"
        return redirect()->route('rc-models.index');
    }

    /**
     * Display the specified rc model.
     * @param string $id
     * @return \Inertia\Response
     */
    public function show(string $id)
    {
        return inertia("RcModel", [
            'rc-model' => RcModel::with(['engines', 'batteries', 'propellers', 'transmitter'])->where('id', "=", $id)->first(),
            'flights' => $this->getRcModelFlights($id),
        ]);
    }

    /**
     * Show the form to edit the specified rc model.
     * @param string $id
     * @return \Inertia\Response
     */
    public function edit(string $id)
    {
        return inertia("RcModelEdit", [
            'rc-model' => RcModel::with(['engines', 'batteries', 'propellers', 'transmitter'])->where('id', "=", $id)->first(),
            'transmitters' => Transmitter::all(),
            'engines' => Engine::all(),
            'propellers' => Propeller::all(),
            'batteries' => Battery::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param RcModel $rcModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RcModel $rcModel)
    {
        // * Getting the rc model data from the request
        $input = collect(request()->get('rcModel'));

        // * Updating the rc model in the database
        DB::transaction(function () use ($input, $rcModel) {
            $rcModel->update($input->only([
                'name',
                'manufacturer',
                'description',
                'wingSpan',
                'weight',
                'length',
                'height',
                'acquired_on',
                'finished_on',
                'first_flown_on',
                'transmitter_id',
                'flights_offset',
            ])->toArray());
            // * Syncing the engines, propellers and batteries to the rc model
            $engines = collect($input->get('engines'));
            $rcModel->engines()->sync(
                $engines->mapWithKeys(fn ($engine) => [$engine['id'] => ['quantity' => $engine['pivot']['quantity']]])
            );
            $propellers = collect($input->get('propellers'));
            $rcModel->propellers()->sync(
                $propellers->mapWithKeys(fn ($propeller) => [$propeller['id'] => ['quantity' => $propeller['pivot']['quantity']]])
            );
            $batteries = collect($input->get('batteries'));
            $rcModel->batteries()->sync(
                $batteries->mapWithKeys(fn ($battery) => [$battery['id'] => ['quantity' => $battery['pivot']['quantity']]])
            );
        });

        // * Redirecting to this rc model page with a success message
        return redirect()->route('rc-models.show', $rcModel->id)->with(['message' => 'Modèle réduit mit à jour avec succès!', 'type' => 'success']);
    }

    /**
     * Update the image in storage.
     * @param string $rcModelid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(string $rcModelid)
    {
        // * Validation of the image
        request()->validate([
            'image' => [
                'required',
                File::image()
                    ->max(12 * 1024)
            ]
        ]);

        // * Storing the image named after the rc model id
        request()->file('image')->storeAs("RcModelsImages", $rcModelid . ".jpg");

        // * Redirecting to the previous location
        return back();
    }

    /**
     * Remove the rc model from the DB & its image from storage.
     * @param string $rcModelid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $rcModelid)
    {
        // * Getting the rc model from the database
        $rcModel = RcModel::find($rcModelid);

        // * Deleting the rc model from the database
        $rcModel->delete();

        // * Deleting the image from the storage
        Storage::delete("RcModelsImages/{$rcModelid}.jpg");

        // * Redirecting to the "homepage" with a success message
        return redirect()->route('rc-models.index')->with(['message' => 'Modèle réduit supprimé avec succès!', 'type' => 'success']);
    }

    /**
     * Get the flights of the rc model.
     * @param string $rcModelId
     * @return array
     */
    public function getRcModelFlights(string $rcModelId)
    {
        return [
            'flights' => Flights::where('rc_model_id', "=", $rcModelId)->get(),
            'quantity' => Flights::where('rc_model_id', "=", $rcModelId)->count() + RcModel::where('id', "=", $rcModelId)->first()->flights_offset,
        ];
    }

    /**
     * Get the rc model image.
     * @param string $rcModelId
     * @return \Illuminate\Http\Response
     */
    public function getRcModelImage(string $rcModelId)
    {
        // * Getting the image from the storage
        $filepath = storage_path("/app/RcModelsImages/{$rcModelId}.jpg");

        // * Returning the image
        return response()->file($filepath);
    }
}
