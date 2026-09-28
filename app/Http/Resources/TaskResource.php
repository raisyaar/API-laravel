<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'title_tasks'       => $this->title_tasks,
            'tasks_description' => $this->tasks_description,
            'status'            => $this->status,
            'owner'             => new UserResource($this->whenLoaded('owner')),
            'assignees_count'   => $this->assignees_count,
            'assignees'         => UserResource::collection($this->whenLoaded('assignees')),
            'comments_count'    => $this->comments_count,
            'tags'              => TagResource::collection($this->whenLoaded('tags')),
            'comments'          => $this->whenLoaded('comments', function () {
                return $this->comments->map(fn($c) => [
                    'id'           => $c->id,
                    'content'      => $c->content,
                    'user_name'    => $c->user->name ?? null,
                    'commented_at' => $c->commented_at?->toISOString()
                ]);
            }),
        ];
    }
}