<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('username', 'test')->first();
        \App\Models\Contact::create([
            'user_id' => $user->id,
            'first_name' => 'raisa',
            'last_name' => 'lewellyn',
            'email' => 'isa@pzn.com',
            'phone' => '03242343243'
        ]);
    }
}
