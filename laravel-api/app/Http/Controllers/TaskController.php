<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    private $tasksFile;

    public function __construct()
    {
        $this->tasksFile = storage_path('app/tasks.json');
    }

    public function index()
    {
        $tasks = $this->getTasks();
        Log::info('Tasks retrieved', ['tasks' => $tasks]);
        return response()->json(['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $tasks = $this->getTasks();
        $newTask = [
            'id' => count($tasks) + 1,
            'title' => $request->input('title'),
            'completed' => false
        ];
        $tasks[] = $newTask;
        $this->saveTasks($tasks);
        Log::info('New task created', ['task' => $newTask]);
        return response()->json($newTask, 201);
    }

    public function update(Request $request, $id)
    {
        $tasks = $this->getTasks();
        Log::info('Updating task', ['id' => $id, 'tasks' => $tasks]);
        
        $id = intval($id);
        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                $task['completed'] = $request->input('completed');
                $this->saveTasks($tasks);
                Log::info('Task updated', ['task' => $task]);
                return response()->json($task);
            }
        }
        
        Log::warning('Task not found', ['id' => $id]);
        return response()->json(['message' => 'Task not found'], 404);
    }

    private function getTasks()
    {
        if (!file_exists($this->tasksFile)) {
            return [
                ['id' => 1, 'title' => 'Task 1', 'completed' => false],
                ['id' => 2, 'title' => 'Task 2', 'completed' => false],
                ['id' => 3, 'title' => 'Task 3', 'completed' => false],
            ];
        }
        return json_decode(file_get_contents($this->tasksFile), true) ?: [];
    }

    private function saveTasks($tasks)
    {
        file_put_contents($this->tasksFile, json_encode($tasks));
    }
}
