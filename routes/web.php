<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\EntidadeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;


Route::post(
    'tickets/{ticket}/messages',
    [TicketMessageController::class, 'store']
)->name('tickets.messages.store');

Route::middleware(['auth'])->group(function () {

    Route::resource('inboxes', InboxController::class);

    Route::resource('inboxes.tickets', TicketController::class)
        ->shallow();
});


Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::resource('entidades', EntidadeController::class);
});


Route::resource('inboxes', InboxController::class);


Route::resource('contactos', ContactoController::class);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('inboxes', InboxController::class);
});


require __DIR__.'/auth.php';
