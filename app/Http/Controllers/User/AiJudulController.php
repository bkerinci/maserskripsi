<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TopicIdea;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class AiJudulController extends Controller
{
    public function index()
    {
        return view('user.ai-judul.index');
    }

    public function generate(Request $request, GeminiService $gemini)
    {
        $validated = $request->validate([
            'minat' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        // Panggil service AI
        $results = $gemini->generateTopics(
            $validated['minat'], 
            $validated['bidang'], 
            $validated['lokasi'] ?? null
        );

        // Simpan ke DB
        $topicIdea = auth()->user()->topicIdeas()->create([
            'input_minat' => $validated['minat'],
            'input_bidang' => $validated['bidang'],
            'input_lokasi' => $validated['lokasi'] ?? null,
            'results' => $results,
        ]);

        return redirect()->route('user.ai-judul.show', $topicIdea);
    }

    public function show(TopicIdea $topicIdea)
    {
        if ($topicIdea->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.ai-judul.result', compact('topicIdea'));
    }

    public function history()
    {
        $histories = auth()->user()->topicIdeas()->latest()->paginate(10);
        return view('user.ai-judul.history', compact('histories'));
    }
}
