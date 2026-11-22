<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(['name' => 'Gibran', 'email' => 'gibran@gmail.com']);
        User::factory()->create(['name' => 'Sari', 'email' => 'sari@example.com']);
        $this->call(MediaSeeder::class);
    }
}
