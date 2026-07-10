<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::latest()->paginate(10);
        return view('admin.personas.index', compact('personas'));
    }

    public function create()
    {
        return view('admin.personas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'system_prompt' => 'nullable|string',
        ]);

        Persona::create($validated);

        return redirect()->route('admin.personas.index')->with('success', 'Persona berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $persona = Persona::findOrFail($id);
        return view('admin.personas.show', compact('persona'));
    }

    public function edit(string $id)
    {
        $persona = Persona::findOrFail($id);
        return view('admin.personas.edit', compact('persona'));
    }

    public function update(Request $request, string $id)
    {
        $persona = Persona::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'system_prompt' => 'nullable|string',
        ]);

        $persona->update($validated);

        return redirect()->route('admin.personas.index')->with('success', 'Persona berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return redirect()->route('admin.personas.index')->with('success', 'Persona berhasil dihapus');
    }
}
