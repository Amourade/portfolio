<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        /* for($i = 0; $i < 80; $i++){
            \App\Models\Painting::factory()->create();
        }

        for($i = 0; $i < 30; $i++){
            \App\Models\Drawing::factory()->create();
        }

        for($i = 0; $i < 15; $i++){
            \App\Models\Project::factory()->create();
        }

        for($i = 0; $i < 20; $i++){
            \App\Models\Digital::factory()->create();
        } */

        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'theriault.antoine@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Bitch328'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
