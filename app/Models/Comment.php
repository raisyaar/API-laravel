<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'commentable_id', 'commentable_type',
        'user_id', 'content', 'commented_at'
    ];

    protected $casts = [
        'commented_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('commented_at', 'desc');
    }

    public function scopeWithUser($query)
    {
        return $query->with('user:id,name,email');
    }
}