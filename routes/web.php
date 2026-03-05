<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\EntidadeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/teste-cliente', function() {
    return 'Rota de teste funciona!';
})->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ======================
    // ROTAS PARA CLIENTES
    // ======================
    Route::get('/meus-tickets', [TicketController::class, 'meusTickets'])->name('meus.tickets');
    Route::get('/clientes/tickets/create', [TicketController::class, 'createCliente'])->name('clientes.tickets.create');
    Route::post('/clientes/tickets', [TicketController::class, 'storeCliente'])->name('clientes.tickets.store');

    // ======================
    // ROTAS PARA USERS (ADMIN/OPERADOR)
    // ======================
    Route::resource('users', UserController::class)->except(['show']);

    // ======================
    // ROTAS PARA INBOXES E TICKETS
    // ======================
    Route::resource('inboxes', InboxController::class);

    // Rotas aninhadas para tickets dentro de inboxes
    Route::resource('inboxes.tickets', TicketController::class)->shallow();

    // ======================
    // ROTAS PARA ENTIDADES E CONTACTOS
    // ======================
    Route::resource('entidades', EntidadeController::class);
    Route::resource('contactos', ContactoController::class);

    // ======================
    // ROTAS PARA MENSAGENS
    // ======================
    Route::post('tickets/{ticket}/messages', [TicketMessageController::class, 'store'])
        ->name('tickets.messages.store');

    // ======================
    // ROTAS PARA PERFIL
    // ======================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
