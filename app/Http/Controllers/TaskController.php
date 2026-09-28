<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create(array_merge($request->validated(), [
            'user_id' => Auth::id()
        ]));

        return response()->json([
            'data' => (new TaskResource($task))->resolve(),
            'errors' => null
        ], 201);
    }

    public function show(Task $task): JsonResponse
{
    $task->load(['owner', 'assignees', 'tags', 'comments'])
         ->loadCount(['assignees', 'comments']); // <-- tambah ini

    return response()->json([
        'data' => (new TaskResource($task))->resolve(),
        'errors' => null
    ]);
}

    public function update(StoreTaskRequest $request, Task $task): JsonResponse
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $task->update($request->validated());

        return response()->json([
            'data' => (new TaskResource($task))->resolve(),
            'errors' => null
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $task->delete();

        return response()->json([
            'data' => 'Task deleted successfully',
            'errors' => null
        ]);
        

    }
}
