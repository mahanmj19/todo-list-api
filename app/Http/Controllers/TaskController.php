<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $isDone = $request->query('is_done');
        $tasks = $this->service->getAll($isDone);

        return response()->json([
            'status' => 'success',
            'message' => 'All Tasks successfully',
            'result' => TaskResource::collection($tasks)
        ]);
    }

    public function show(Task $task)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Task Show successfully',
            'result' => new TaskResource($task)
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $task = $this->service->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'result' => new TaskResource($task)
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $task = $this->service->update($task, $data);

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'result' => new TaskResource($task)
        ]);
    }

    public function destroy(Task $task)
    {
        $this->service->delete($task);
        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
            'result' => null
        ], 200);
    }

    public function toggle(Task $task)
    {
        $task = $this->service->toggle($task);
        return response()->json([
            'status' => 'success',
            'message' => 'Task status toggled successfully',
            'result' => new TaskResource($task)
        ]);
    }
}
