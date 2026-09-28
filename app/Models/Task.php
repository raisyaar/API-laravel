<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title_tasks', 'tasks_description', 'status'];

    protected $casts = ['status' => 'string'];

    // MorphMany Comments ⭐
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->with('user:id,name')
                    ->orderBy('commented_at', 'desc');
    }

    // Many-to-Many Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tags')
                    ->withTimestamps();
    }

    // Many-to-Many Assignees
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'tasks_assignees', 'task_id', 'user_id')
                    ->withPivot([]);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}