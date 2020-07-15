<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++){
            $course['title'] = Str::random(25);
            $course['subtitle'] = Str::random(25);
            $course['description'] = Str::random(rand(300, 700));
            $course['startedAt'] = \Illuminate\Support\Carbon::now();
            $course['active'] = true;
            \App\Course::create($course);
        }
    }
}
