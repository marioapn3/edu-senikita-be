<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Requirement;
use App\Models\SneakPeek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Dasar-dasar Piano untuk Pemula',
                'description' => 'Kursus ini dirancang untuk pemula yang ingin belajar piano dari dasar. Anda akan mempelajari teknik dasar, membaca not, dan memainkan lagu-lagu sederhana.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'dasar-dasar-piano-untuk-pemula',
                'duration' => 1800, // 30 jam
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1, // Sesuaikan dengan ID instructor yang sudah ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Teknik Vokal Intermediate',
                'description' => 'Kursus lanjutan untuk mengembangkan teknik vokal. Mencakup teknik pernapasan, pitch control, dan pengembangan range vokal.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'teknik-vokal-intermediate',
                'duration' => 2400, // 40 jam
                'level' => 'menengah',
                'status' => 'published',
                'instructor_id' => 2, // Sesuaikan dengan ID instructor yang sudah ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Master Gitar Klasik',
                'description' => 'Kursus tingkat lanjut untuk pemain gitar klasik. Fokus pada teknik fingerpicking tingkat tinggi dan interpretasi musik klasik.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'master-gitar-klasik',
                'duration' => 3600, // 60 jam
                'level' => 'lanjutan',
                'status' => 'draft',
                'instructor_id' => 3, // Sesuaikan dengan ID instructor yang sudah ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $sneakpeeks = [
            'Dasar-dasar Piano untuk Pemula',
            'Teknik Vokal Intermediate',
            'Master Gitar Klasik',
        ];

        $requirements = [
            'Piano',
            'Vokal',
            'Gitar',
        ];

        // DB::table('courses')->insert($courses);

        // Menambahkan relasi kategori untuk setiap kursus
        foreach($courses as $course) {
            // $courseId = DB::table('courses')->insertGetId($course);
            $course = Course::create($course);
            $course->categories()->attach(1);

            foreach($sneakpeeks as $sneakpeek) {
                SneakPeek::where('course_id', $course->id)->delete();
                SneakPeek::create([
                    'text' => $sneakpeek,
                    'course_id' => $course->id,
                ]);
            }

            foreach($requirements as $requirement) {
                Requirement::where('course_id', $course->id)->delete();
                Requirement::create([
                    'text' => $requirement,
                    'course_id' => $course->id,
                ]);
            }


        }

    }
}
