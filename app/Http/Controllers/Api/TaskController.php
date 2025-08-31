<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['statusTask', 'observer.user', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($tasks);
    }
}
