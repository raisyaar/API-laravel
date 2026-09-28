<?php
// database/seeders/TaskSeeder.php
namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $user1 = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $user2 = User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        // Task by User 1
        $task = Task::create([
            'user_id' => $user1->id,
            'title_tasks' => 'Fix Login Authentication',
            'tasks_description' => 'Users cannot login with valid credentials',
            'status' => 'in_progress'
        ]);

        // Comments (MorphMany)
        $task->comments()->createMany([
            [
                'user_id' => $user1->id,
                'content' => 'Issue found in Auth middleware. Working on fix.'
            ],
            [
                'user_id' => $user2->id, 
                'content' => 'I can help with testing tomorrow morning.'
            ]
        ]);

        // Tags
        $urgentTag = Tag::create(['name' => 'urgent', 'color' => '#e74c3c']);
        $bugTag = Tag::create(['name' => 'bug', 'color' => '#f39c12']);
        $task->tags()->attach([$urgentTag->id, $bugTag->id]);

        // Assignees
        $task->assignees()->attach($user2->id);
    }
}