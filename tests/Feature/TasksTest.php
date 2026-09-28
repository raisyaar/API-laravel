<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{
   public function testCreateSucces()
   {
        $this->seed(User::class);

        $this->post('/api/tasks', [
        'title_tasks' => 'Task 1',
        'tasks_description' => 'Description of Task 1',
        'status' => 'pending',
    ], [
        'Authorization' => 'test' 
    ])->assertStatus(201)
      ->assertJson([ 
            'data' => [
                'title_tasks' => 'Task 1',
                'tasks_description' => 'Description of Task 1',
                'status' => 'pending',
            ],
        ]);
   }
   public function testCreateFailed()
   {
     
   }
}
