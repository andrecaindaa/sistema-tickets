<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use Illuminate\Http\Request;
use App\Models\User;

class InboxController extends Controller
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
    public function create()
    {
        $operadores = User::where('role', 'operador')->get();

        return view('inboxes.create', compact('operadores'));
    }


    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
            'operadores' => 'nullable|array',
            'operadores.*' => 'exists:users,id'
        ]);

        $inbox = Inbox::create([
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'ativo' => $validated['ativo'] ?? true,
        ]);

        if(isset($validated['operadores'])) {
            $inbox->operadores()->sync($validated['operadores']);
        }

        return redirect()->route('inboxes.index')
            ->with('success', 'Inbox criada com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Inbox $inbox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inbox $inbox)
    {
        $operadores = User::where('role', 'operador')->get();

        return view('inboxes.edit', compact('inbox', 'operadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inbox $inbox)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
            'operadores' => 'nullable|array',
            'operadores.*' => 'exists:users,id'
        ]);

        $inbox->update([
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'ativo' => $validated['ativo'] ?? true,
        ]);

        $inbox->operadores()->sync($validated['operadores'] ?? []);

        return redirect()->route('inboxes.index')
            ->with('success', 'Inbox atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inbox $inbox)
    {
        //
    }
}
