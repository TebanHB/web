<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PropositionController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Route::resource('clients', ClientController::class)->only([
    'create', 'store'
])->names([
    'create' => 'clients.create',
    'store' => 'clients.store',
]);
Route::resource('workshops', WorkshopController::class)->only([
    'create', 'store'
])->names([
    'create' => 'workshops.create',
    'store' => 'workshops.store',
]);
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('vehicles', VehicleController::class)->names([
        'index' => 'vehicles.index',
        'create' => 'vehicles.create',
        'store' => 'vehicles.store',
        'show' => 'vehicles.show',
        'edit' => 'vehicles.edit',
        'update' => 'vehicles.update',
        'destroy' => 'vehicles.destroy',
    ]);
    Route::resource('workers', WorkerController::class)->names([
        'index' => 'workers.index',
        'create' => 'workers.create',
        'store' => 'workers.store',
        'show' => 'workers.show',
        'edit' => 'workers.edit',
        'update' => 'workers.update',
        'destroy' => 'workers.destroy',
    ]);
    Route::resource('clients', ClientController::class)->except(['create','store'])->names([
        'index' => 'clients.index',
        'show' => 'clients.show',
        'edit' => 'clients.edit',
        'update' => 'clients.update',
        'destroy' => 'clients.destroy',
    ]);
    Route::resource('workshops', ClientController::class)->except(['create','store'])->names([
        'index' => 'workshops.index',
        'show' => 'workshops.show',
        'edit' => 'workshops.edit',
        'update' => 'workshops.update',
        'destroy' => 'workshops.destroy',
    ]);

    Route::get('/user-test', [AuthController::class, 'getUserByToken'])->middleware('auth');



    Route::get('propositions/create2/{id}', [PropositionController::class,'create2'])->name('propositions.create2');
    Route::resource('service_requests', ServiceRequestController::class)->names([
        'index' => 'service_requests.index',
        'create' => 'service_requests.create',
        'store' => 'service_requests.store',
        'show' => 'service_requests.show',
        'edit' => 'service_requests.edit',
        'update' => 'service_requests.update',
        'destroy' => 'service_requests.destroy',
    ]);
    Route::resource('propositions', PropositionController::class)->names([
        'index' => 'propositions.index',
        'create' => 'propositions.create',
        'store' => 'propositions.store',
        'show' => 'propositions.show',
        'edit' => 'propositions.edit',
        'update' => 'propositions.update',
        'destroy' => 'propositions.destroy',
    ]);
    Route::get('/vehicles/{vehicle}/photos', [VehicleController::class, 'photos'])->name('vehicles.photos');
    Route::get('/myprofile', [UserController::class, 'profile'])->name('myprofile');
});
Auth::routes([
    'register' => false,
]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
