<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskController extends Controller
{
    public function index(Request $request, int $categoryId): JsonResource
    {
        $tasks = Task::query()->where('category_id', $categoryId)->get();

        return TaskResource::collection($tasks);
    }

    public function store(TaskCreateRequest $request): JsonResource
    {
        $task = Task::create($request->validated());

        return TaskResource::make($task);
    }
}
