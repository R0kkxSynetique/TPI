<?php

namespace App\Http\Controllers;

use App\Models\Battery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BatteryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia("Batteries", [
            'batteries' => Battery::where('user_id', "=", Auth::user()->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ! this wont be used because the creation is made via a modal 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // * Getting the battery data from the request
        $input = collect(request()->get('battery'));

        // * Replacing the user id placeholder in the battery
        $input->put('user_id', Auth::user()->id);

        // * Creating the battery in the database
        DB::transaction(function () use ($input) {
            $battery = Battery::create($input->only([
                'capacity',
                'cells',
                'type',
                'cRate',
                'user_id'
            ])->toArray());
            return $battery;
        });

        // * Redirecting to the user's batteries list
        return back();
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
            'battery' => Battery::find($id),
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $batteryId)
    {
        $input = collect(request()->get('battery'));

        $battery = Battery::find($batteryId);

        DB::transaction(function () use ($input, $battery) {
            $battery->update($input->only([
                'capacity',
                'cells',
                'type',
                'cRate',
            ])->toArray());
        });

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $batteryId)
    {
        $battery = Battery::find($batteryId);

        $battery->delete();

        return back();
    }
}
