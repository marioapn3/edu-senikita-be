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
                'slug' => 'dasar-dasar-piano-untuk-pemula1',
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
                'slug' => 'teknik-vokal-intermediate2',
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
                'slug' => 'master-gitar-klasik3',
                'level' => 'lanjutan',
                'status' => 'draft',
                'instructor_id' => 3, // Sesuaikan dengan ID instructor yang sudah ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Belajar Biola untuk Pemula',
                'description' => 'Pelajari teknik dasar bermain biola dan cara membaca notasi musik untuk pemula.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'belajar-biola-untuk-pemula4',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Drum Set Dasar',
                'description' => 'Kuasai teknik dasar drum, ketukan dasar, dan koordinasi tangan-kaki.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'drum-set-dasar5',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Improvisasi Jazz untuk Pianis',
                'description' => 'Pelajari teknik improvisasi dalam musik jazz menggunakan piano.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'improvisasi-jazz-untuk-pianis6',
                'level' => 'lanjutan',
                'status' => 'draft',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Teori Musik Dasar',
                'description' => 'Kursus ini akan mengenalkan teori musik seperti tangga nada, interval, dan harmoni.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'teori-musik-dasar7',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gitar Elektrik: Teknik Shredding',
                'description' => 'Fokus pada teknik cepat bermain gitar elektrik termasuk legato dan alternate picking.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'gitar-elektrik-teknik-shredding8',
                'level' => 'lanjutan',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Belajar Biola untuk Pemula',
                'description' => 'Pelajari teknik dasar bermain biola dan cara membaca notasi musik untuk pemula.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'belajar-biola-untuk-pemula9',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Drum Set Dasar',
                'description' => 'Kuasai teknik dasar drum, ketukan dasar, dan koordinasi tangan-kaki.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'drum-set-dasa10',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Improvisasi Jazz untuk Pianis',
                'description' => 'Pelajari teknik improvisasi dalam musik jazz menggunakan piano.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'improvisasi-jazz-untuk-pianis11',
                'level' => 'lanjutan',
                'status' => 'draft',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Teori Musik Dasar',
                'description' => 'Kursus ini akan mengenalkan teori musik seperti tangga nada, interval, dan harmoni.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'teori-musik-dasar12',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gitar Elektrik: Teknik Shredding',
                'description' => 'Fokus pada teknik cepat bermain gitar elektrik termasuk legato dan alternate picking.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'gitar-elektrik-teknik-shredding13',
                'level' => 'lanjutan',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Drum Set Dasar',
                'description' => 'Kuasai teknik dasar drum, ketukan dasar, dan koordinasi tangan-kaki.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'drum-set-dasar14',
                'level' => 'pemula',
                'status' => 'published',
                'instructor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Improvisasi Jazz untuk Pianis',
                'description' => 'Pelajari teknik improvisasi dalam musik jazz menggunakan piano.',
                'certificate_available' => true,
                'thumbnail' => null,
                'slug' => 'improvisasi-jazz-untuk-pianis15',
                'level' => 'lanjutan',
                'status' => 'draft',
                'instructor_id' => 1,
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
