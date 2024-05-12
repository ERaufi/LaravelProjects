<?php

namespace Database\Seeders;

use App\Models\Countries;
use App\Models\Products;
use App\Models\Schedule;
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
        // User::factory(10)->create();
        Products::factory(100)->create();
        Schedule::factory(20)->create();
        $this->call([
            CountriesSeeder::class
        ]);
        // Countries::factory(195)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
