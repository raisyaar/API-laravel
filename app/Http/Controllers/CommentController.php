<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $idTask): JsonResponse
    {
        $task = Task::findOrFail($idTask);

        $comment = $task->comments()->create([
            'user_id'      => Auth::id(),
            'content'      => $request->content,
            'commented_at' => now()
        ]);

        return response()->json([
            'data' => [
                'id'           => $comment->id,
                'content'      => $comment->content,
                'user_name'    => $comment->user->name,
                'commented_at' => $comment->commented_at?->toISOString()
            ],
            'errors' => null
        ], 201);
    }

    public function destroy($idTask, $idComment): JsonResponse
    {
        $task = Task::findOrFail($idTask);
        $comment = Comment::findOrFail($idComment);

        if (Auth::id() != $comment->user_id && Auth::id() !== $task->user_id) {
            return response()->json([
                'errors' => ['message' => ['Unauthorized']]
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'data'   => 'Comment deleted successfully',
            'errors' => null
        ]);
    }
}