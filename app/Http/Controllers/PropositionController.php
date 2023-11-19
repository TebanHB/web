<?php

namespace App\Http\Controllers;

use App\Models\Proposition;
use App\Models\ServiceRequest;
use App\Models\Workshop;
use App\Notifications\PropositionCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create2($id)
    {
        $workshop = Workshop::where('user_id', Auth::id())->first();
        $service_request = ServiceRequest::findOrFail($id);
        return view('proposition.create', compact('service_request', 'workshop'));
    }
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $propostion = new Proposition();
        $propostion->workshop_id = $request->workshop_id;
        $propostion->service_request_id = $request->service_request_id;
        $propostion->price = $request->price;
        $propostion->save();

        $user = ServiceRequest::find($request->service_request_id)->client->user;
        $user->notify(new PropositionCreated());
        $user->session()->flash('message', 'Notification sent!');
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
