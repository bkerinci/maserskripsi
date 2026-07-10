<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Persona;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    public function index()
    {
        $prompts = Prompt::with('persona')->latest()->paginate(10);
        return view('admin.prompts.index', compact('prompts'));
    }

    public function create()
    {
        $personas = Persona::all();
        return view('admin.prompts.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|max:255',
            'persona_id' => 'nullable|exists:personas,id',
        ]);

        Prompt::create($validated);

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $prompt = Prompt::findOrFail($id);
        return view('admin.prompts.show', compact('prompt'));
    }

    public function edit(string $id)
    {
        $prompt = Prompt::findOrFail($id);
        $personas = Persona::all();
        return view('admin.prompts.edit', compact('prompt', 'personas'));
    }

    public function update(Request $request, string $id)
    {
        $prompt = Prompt::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|max:255',
            'persona_id' => 'nullable|exists:personas,id',
        ]);

        $prompt->update($validated);

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $prompt = Prompt::findOrFail($id);
        $prompt->delete();

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt berhasil dihapus');
    }
}
