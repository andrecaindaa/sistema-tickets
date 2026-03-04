<?php



namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ADMIN
        if ($user->isAdmin()) {

            $inboxes = Inbox::withCount([
                'tickets as tickets_abertos_count' => function ($q) {
                    $q->whereHas('estado', function ($q2) {
                        $q2->where('nome', '!=', 'Fechado');
                    });
                }
            ])->get();

            return view('dashboard', compact('inboxes'));
        }

        // OPERADOR
        if ($user->isOperador()) {

            $inboxes = $user->inboxes()
                ->withCount([
                    'tickets as tickets_abertos_count' => function ($q) {
                        $q->whereHas('estado', function ($q2) {
                            $q2->where('nome', '!=', 'Fechado');
                        });
                    }
                ])
                ->get();

            return view('dashboard', compact('inboxes'));
        }

        // CLIENTE
        if ($user->isCliente()) {

            $meusTickets = Ticket::where('user_id', $user->id)
                ->whereHas('estado', function ($q) {
                    $q->where('nome', '!=', 'Fechado');
                })
                ->count();

            return view('dashboard', compact('meusTickets'));
        }
    }
}
