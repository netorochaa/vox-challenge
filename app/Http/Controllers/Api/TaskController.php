<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskMoveRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskController extends Controller
{
    public function index(Request $request, int $categoryId): JsonResource
    {
        $tasks = Task::query()
            ->where('category_id', $categoryId)
            ->orderBy('order')
            ->get();

        return TaskResource::collection($tasks);
    }

    public function store(TaskCreateRequest $request): JsonResource
    {
        $data = $request->validated();

        $order = Task::query()->where('category_id', $data['category_id'])->count() + 1;

        $task = Task::create([
            ...$data,
            'order' => $order,
        ]);

        return TaskResource::make($task);
    }

    public function move(TaskMoveRequest $taskMoveRequest): JsonResponse
    {
        $data = data_get($taskMoveRequest->validated(), 'data', []);

        foreach ($data as $taskData) {
            $task = Task::findOrFail($taskData['task_id']);
            $task->update([
                'category_id' => $taskData['category_id'],
                'order'       => $taskData['order'],
            ]);
        }

        return response()->json(['message' => 'Tasks movidas com sucesso'], 200);
    }
}
