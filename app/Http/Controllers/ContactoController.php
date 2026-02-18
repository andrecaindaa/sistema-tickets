<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Entidade;
use App\Models\Funcao;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        $contactos = Contacto::with(['funcao', 'entidades'])
            ->orderBy('nome')
            ->get();

        return view('contactos.index', compact('contactos'));
    }

    public function create()
    {
        $funcoes = Funcao::orderBy('nome')->get();
        $entidades = Entidade::orderBy('nome')->get();

         $contacto = new Contacto();

        return view('contactos.create', compact('funcoes', 'entidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'funcao_id' => 'required|exists:funcoes,id',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'telemovel' => 'nullable|string|max:20',
            'notas_internas' => 'nullable|string',
            'entidades' => 'required|array',
            'entidades.*' => 'exists:entidades,id'
        ]);

        $contacto = Contacto::create($validated);

        $contacto->entidades()->sync($validated['entidades']);

        return redirect()->route('contactos.index')
            ->with('success', 'Contacto criado com sucesso.');
    }

    public function edit(Contacto $contacto)
    {
        $funcoes = Funcao::orderBy('nome')->get();
        $entidades = Entidade::orderBy('nome')->get();

        $contacto->load('entidades');

        return view('contactos.edit', compact('contacto', 'funcoes', 'entidades'));
    }

    public function update(Request $request, Contacto $contacto)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'funcao_id' => 'required|exists:funcoes,id',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'telemovel' => 'nullable|string|max:20',
            'notas_internas' => 'nullable|string',
            'entidades' => 'required|array',
            'entidades.*' => 'exists:entidades,id'
        ]);

        $contacto->update($validated);
        $contacto->entidades()->sync($validated['entidades']);

        return redirect()->route('contactos.index')
            ->with('success', 'Contacto atualizado com sucesso.');
    }

    public function destroy(Contacto $contacto)
    {
        $contacto->delete();

        return redirect()->route('contactos.index')
            ->with('success', 'Contacto eliminado com sucesso.');
    }
}
