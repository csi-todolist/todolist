<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MistralController extends Controller
{
    public function generateTasks(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = env('MISTRAL_API_KEY'); // Ajoute ta clé dans .env

        // Appel à l’API Mistral
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->withoutVerifying()
        ->post('https://api.mistral.ai/v1/chat/completions', [
            'model' => 'mistral-small',
            'messages' => [
                [
                    "role" => "user",
                    "content" => "(toujours en français avec un titre et une description séparé d'un '/') : " . $prompt
                    // "content" => "Génère une ou des tâches avec a chaque fois un titre et une description (toujours en français) à partir de ce texte : " . $prompt
                ]
            ],
            "temperature" => 0.7,
            "max_tokens" => 256
        ]);

        if ($response->successful()) {
            $content = $response->json()['choices'][0]['message']['content'] ?? '';
            return response()->json(['tasks' => $content]);
        } else {
            \Log::error('Mistral API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json(['error' => 'Erreur IA', 'details' => $response->body()], 500);
        }
    }
}
