<?php

namespace App\Http\Controllers;

use App\Models\Engine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class EngineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia("Engines", [
            'engines' => Engine::where('user_id', "=", Auth::user()->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("EngineCreation");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // * Validation of the image
        request()->validate([
            'image' => [
                'required',
                File::image()
                    ->max(12 * 1024)
            ]
        ]);

        // * Getting the engine data from the request
        $input = collect(request()->get('engine'));

        // * Replacing the user id placeholder in the engine
        $input->put('user_id', Auth::user()->id);

        // * Creating the engine in the database
        $engine = DB::transaction(function () use ($input) {
            $engine = Engine::create($input->only([
                'name',
                'power',
                'frequency',
                'type',
                'weight',
                'fuel',
                'user_id'
            ])->toArray());
            return $engine;
        });

        // * Storing the image named after the engine id
        request()->file('image')->storeAs("EnginesImages", $engine->id . ".jpg");

        // * Redirecting to the engines
        return redirect()->route('engines.index')->with(['message' => 'Votre moteur à été crée avec succès', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return [
            'engine' => Engine::find($id),
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $engineId)
    {
        $input = collect(request()->get('engine'));

        if ($input->get('type') == "électrique"){
            $input->put('power', null);
        }

        $engine = Engine::find($engineId);

        DB::transaction(function () use ($input, $engine) {
            $engine->update($input->only([
                'name',
                'power',
                'type',
                'weight',
                'frequency',
                'fuel',            
            ])->toArray());
        });

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $engineId)
    {
        $engine = Engine::find($engineId);

        $engine->delete();
        
        Storage::delete("EnginesImages/{$engineId}.jpg");

        return back();
    }

    /**
     * Get the engine image.
     * @param string $engineId
     * @return \Illuminate\Http\Response
     */
    public function getEngineImage(string $engineId)
    {
        // * Getting the image from the storage
        $filepath = storage_path("/app/EnginesImages/{$engineId}.jpg");

        // * Returning the image
        return response()->file($filepath);
    }
}
