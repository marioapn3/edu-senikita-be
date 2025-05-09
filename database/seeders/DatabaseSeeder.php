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
        User::firstOrCreate([
            'email' => 'adminedu@senikita'
        ],[
            'name' => 'Admin',
            'email' => 'adminedu@senikita',
            'password' => bcrypt('rahasiabangetpasswordnya'),
            'google_id' => null,
            'role' => 'admin',
        ]);

        User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ],[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'google_id' => null,
            'role' => 'admin',
        ]);
        $this->call([
            // InstructorSeeder::class,
            // CategorySeeder::class,
            // CourseSeeder::class,
        ]);
    }
}
