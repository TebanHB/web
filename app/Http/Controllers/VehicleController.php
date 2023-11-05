<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            // Get the vehicles of the authenticated user...
    $vehicles = Vehicle::where('client_id', Auth::user()->client->id)->with('photos')->get();

    // Pass the vehicles to the view...
    return view('vehicles.index', ['vehicles' => $vehicles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->client->exists());
                return view('vehicles.create', compact('user'));
        }
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'make' => 'required',
            'color' => 'required',
            'year' => 'required',
            'client_id' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $vehicle = Vehicle::create($request->all());
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('photos', 'public');
    
                Photo::create([
                    'vehicle_id' => $vehicle->id,
                    'file_path' => $path,
                ]);
            }
        }
        return redirect()->route('vehicles.index');

        dd($request->all());
        
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        foreach ($vehicle->photos as $photo) {
            $photo->delete();
        }
        $client_id = $vehicle->client->id;
        $vehicle->delete();
        $vehicles = Vehicle::where('client_id', $vehicle->client->id)->with('photos')->get();
        return view('vehicles.index', ['vehicles' => $vehicles]);
    }
        public function photos(Vehicle $vehicle)
    {
        $photos = Photo::where('vehicle_id', $vehicle->id)->get();
        return view('vehicles.photos', compact('photos'));
    }
}
