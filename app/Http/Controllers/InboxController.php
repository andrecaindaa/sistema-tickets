<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\User;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $inboxes = Inbox::with('operadores')->orderBy('nome')->get();
        return view('inboxes.index', compact('inboxes'));
    }

    public function create()
    {
        $operadores = User::where('role', 'operador')->get();
        return view('inboxes.create', compact('operadores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
            'operadores' => 'nullable|array',
            'operadores.*' => 'exists:users,id'
        ]);

        $inbox = Inbox::create([
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'ativo' => $request->has('ativo'),
        ]);

        $inbox->operadores()->sync($validated['operadores'] ?? []);

        return redirect()->route('inboxes.index')
            ->with('success', 'Inbox criada com sucesso.');
    }

    public function edit(Inbox $inbox)
    {
        $operadores = User::where('role', 'operador')->get();
        return view('inboxes.edit', compact('inbox', 'operadores'));
    }

    public function update(Request $request, Inbox $inbox)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
            'operadores' => 'nullable|array',
            'operadores.*' => 'exists:users,id'
        ]);

        $inbox->update([
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'ativo' => $request->has('ativo'),
        ]);

        $inbox->operadores()->sync($validated['operadores'] ?? []);

        return redirect()->route('inboxes.index')
            ->with('success', 'Inbox atualizada com sucesso.');
    }

    public function destroy(Inbox $inbox)
    {
        $inbox->delete();

        return redirect()->route('inboxes.index')
            ->with('success', 'Inbox eliminada com sucesso.');
    }
}
