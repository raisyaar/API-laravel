<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class SearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('username', 'test')->first();
        
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Contact::create([
                'first_name' => 'First' .$i,
                'last_name' => 'Last' .$i,
                'email' => 'test' .$i . '@pzn.com',
                'phone' => '11111' .$i,
                'user_id' => $user->id
            ]);
        }
    }
}
