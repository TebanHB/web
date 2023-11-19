<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Photo;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->client && $user->client->exists()) {
            $client = $user->client;
            $serviceRequests = ServiceRequest::where('client_id', $client->id)->where('status', 'pending')->with('photos')->get();
            return view('service_requests.index', compact('serviceRequests'));
        } else {
            $serviceRequests = ServiceRequest::where('status', 'pending')->with('photos')->get();
            return view('service_requests.index', compact('serviceRequests'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $user = Auth::user();
        $client = $user->client;
        $date = Carbon::now();
        $serviceRequest = new ServiceRequest([
            'client_id' => $client->id,
            'date' => $date,
            'location' => $request['location'],
            'description' => $request['description'],
            'status' => 'pending',
        ]);
        $serviceRequest->save();
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('photos', 'public');
                $photo = Photo::create([
                    'vehicle_id' => null,
                    'file_path' => $path,
                    'service_request_id' => $serviceRequest->id,
                ]);
                $photo->save();
            }
        }
        return redirect()->route('service_requests.index')->with('success', 'Service request created successfully.');
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
        //
    }
}
