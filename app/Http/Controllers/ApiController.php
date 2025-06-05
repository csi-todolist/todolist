<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;

class ApiController extends Controller
{
    public function showAll()
    {
        $data = Task::all();
        return response()->json($data);
    }

    public function showOneTask($id)
    {
        $data = Task::find($id);
        return response()->json($data);
    }
}
