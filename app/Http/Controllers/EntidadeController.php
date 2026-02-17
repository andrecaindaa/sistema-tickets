<?php

namespace App\Http\Controllers;

use App\Models\Entidade;
use Illuminate\Http\Request;

class EntidadeController extends Controller
{
    public function index()
    {
        $entidades = Entidade::orderBy('nome')->get();
        return view('entidades.index', compact('entidades'));
    }

    public function create()
    {
        return view('entidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nif' => 'required|string|max:20|unique:entidades,nif',
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'telemovel' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'notas_internas' => 'nullable|string'
        ]);

        Entidade::create($validated);

        return redirect()->route('entidades.index')
            ->with('success', 'Entidade criada com sucesso.');
    }

    public function edit(Entidade $entidade)
    {
        return view('entidades.edit', compact('entidade'));
    }

   public function update(Request $request, Entidade $entidade)
{
    $validated = $request->validate([
        'nif' => 'required|string|max:20|unique:entidades,nif,' . $entidade->id,
        'nome' => 'required|string|max:255',
        'telefone' => 'nullable|string|max:20',
        'telemovel' => 'nullable|string|max:20',
        'website' => 'nullable|url|max:255',
        'email' => 'nullable|email|max:255',
        'notas_internas' => 'nullable|string'
    ]);

    $entidade->update($validated);

    return redirect()->route('entidades.index')
        ->with('success', 'Entidade atualizada com sucesso.');
}

public function destroy(Entidade $entidade)
{
    $entidade->delete();

    return redirect()->route('entidades.index')
        ->with('success', 'Entidade eliminada com sucesso.');
}
}
