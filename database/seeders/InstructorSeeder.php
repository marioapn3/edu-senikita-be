<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instructor;
use Illuminate\Support\Facades\DB;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'John Doe',
                'expertise' => 'Seorang instruktur berpengalaman dalam bidang musik klasik dengan pengalaman mengajar lebih dari 10 tahun.',
                'email' => 'john.doe@example.com',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'expertise' => 'Instruktur profesional dengan spesialisasi dalam piano dan vokal, lulusan Conservatory of Music.',
                'email' => 'jane.smith@example.com',
                'phone' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Rizki',
                'expertise' => 'Instruktur gitar dengan pengalaman mengajar 5 tahun, spesialis dalam genre rock dan jazz.',
                'email' => 'ahmad.rizki@example.com',
                'phone' => '081234567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('instructors')->insert($instructors);
    }
}
