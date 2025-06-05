<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $task = Task::where("user_id", $user->id)
            ->get();

        $data = [
            'user' => $user, 
            'task' => $task
        ];
            // ->map(function($value) use ($user){
            //     return[
            //         'id' => $value->id,
            //         'id_user' => $user->id,
            //         'title' => $value->title,
            //         'description' => $value->description,
            //         'completed' => $value->completed,
            //         'stressLevel' => $value->stressLevel
            //     ];
            // });

        return response()->json($data);
    }

    public function showAll()
    {
        $data = Task::all();
        return response()->json($data);
    }

    public function create(StoreTaskRequest $request){
        Task::create($request->validated());
    }

    public function edit(StoreTaskRequest $request, $id){
        $task = Task::find($id);
        $task->update($request->validated());
    }

    public function delete($id){
        Task::find($id)->delete();
    }

    public function generateTasks(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = env('MISTRAL_API_KEY'); // Ajoute ta clé dans .env

        // Appel à l’API Mistral
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.mistral.ai/v1/chat/completions', [
            'model' => 'mistral-small',
            'messages' => [
                [
                    "role" => "user",
                    "content" => "Génère une liste de tâches concrètes et concises à partir de ce texte (une par ligne) : " . $prompt
                ]
            ],
            "temperature" => 0.7,
            "max_tokens" => 256
        ]);

        if ($response->successful()) {
            // On récupère le texte généré (à adapter selon la réponse de Mistral)
            $content = $response->json()['choices'][0]['message']['content'] ?? '';
            return response()->json(['tasks' => $content]);
        } else {
            return response()->json(['error' => 'Erreur IA'], 500);
        }
    }
}
