<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getAll(?string $isDone = null)
    {
        $query = Task::query();

        if ($isDone !== null) {
            $query->where('is_done', filter_var($isDone, FILTER_VALIDATE_BOOLEAN));
        }
        return $query->get();
    }

    public function create(array $data)
    {
        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'is_done' => $data['is_done'] ?? false,
        ]);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }

    public function toggle(Task $task)
    {
        $task->is_done = !$task->is_done;
        $task->save();
        return $task;
    }
}
