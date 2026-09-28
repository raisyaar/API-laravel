<?php
// app/Http/Controllers/TagController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(Task $task): JsonResponse
    {
        return response()->json([
            'data' => TagResource::collection($task->tags),
            'errors' => null
        ]);
    }

    public function store(StoreTagRequest $request, Task $task): JsonResponse
    {
        // Semua user bisa add tag ✅
        $tag = Tag::updateOrCreate(
            ['name' => $request->name],
            ['color' => $request->color ?? '#3498db']
        );

        $task->tags()->syncWithoutDetaching($tag->id);

        return response()->json([
            'data' => [
                'id' => $tag->id,
                'name' => $tag->name,
                'color' => $tag->color
            ],
            'errors' => null
        ], 201);
    }

    public function destroy(Task $task, Tag $tag): JsonResponse
    {
        // Semua user bisa remove tag ✅
        $task->tags()->detach($tag->id);

        return response()->json([
            'data' => 'Tag removed successfully',
            'errors' => null
        ]);
    }
}