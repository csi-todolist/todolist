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

    public function create(StoreTaskRequest $request){
        Task::create($request->validated());
    }

    public function edit(StoreTaskRequest $request, $id){
        $task = Task::find($id);
        $task->update($request->validated());
    }
}
