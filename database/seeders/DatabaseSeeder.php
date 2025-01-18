<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Primer Usuario',
            'email' => 'primero@example.com',
            'password' => 'cambiame123'
        ]);
        User::factory()->create([
            'name' => 'Segundo Usuario',
            'email' => 'segundo@example.com',
            'password' => 'cambiame123'
        ]);

        // User::factory(10)->create();

        $this->call([
            ProductSeeder::class,
            CategorySeeder::class
        ]);
    }
}
