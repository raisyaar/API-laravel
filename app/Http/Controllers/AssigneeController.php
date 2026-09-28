<?php
// app/Http/Controllers/AssigneeController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreAssigneeRequest;
use App\Http\Resources\UserResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AssigneeController extends Controller
{
    public function index(Task $task): JsonResponse
    {
        return response()->json([
            'data' => UserResource::collection($task->assignees),
            'errors' => null
        ]);
    }

    public function store(StoreAssigneeRequest $request, Task $task): JsonResponse
    {
        $user = User::findOrFail($request->user_id);

        // Cek duplicate
        if ($task->assignees()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'data' => UserResource::make($user),
                'errors' => ['message' => ['User already assigned']]
            ]);
        }

        $task->assignees()->attach($user->id);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'errors' => null
        ], 201);
    }

    public function destroy(Task $task, $userId): JsonResponse
    {
        $task->assignees()->detach($userId);

        return response()->json([
            'data' => 'Assignee removed successfully',
            'errors' => null
        ]);
    }
}