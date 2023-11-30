<?php

namespace App\Http\Controllers;

use App\Models\Proposition;
use App\Models\ServiceRequest;
use App\Models\Workshop;
use App\Notifications\PropositionCreated;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Messaging\CloudMessage;

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
//        $user->notify(new PropositionCreated());
//        $user->session()->flash('message', 'Notification sent!');

        $messaging = app('firebase.messaging');
        $notification = Notification::create("Nueva Oferta Recibida", "Has recibido una oferta");
        if($user->tokenf != null){
            $message = CloudMessage::withTarget('token', $user->tokenf)
            ->withNotification(Notification::fromArray(['title' => 'New Proposition', 'body' => 'A new proposition has been created'])) // optional
            ->withData(['key' => 'value']); // optional
        $messaging->send($message);
        }
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
