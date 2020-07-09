<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CourseControllerTest extends TestCase
{

    public function testStoreCorrectProduct(){
        $title = 'teste';
        $parameters = [
            'title' => $title,
            'subtitle' => 'PHP 8',
            'description' => 'Um curso legal sobre nao sei o que mas aborda ocurso sei la sei la sei la sei la sei la sei la sei la se',
            'startedAt' => \Carbon\Carbon::now(),
            'active' => '1',
        ];

        $this->post('courses/', $parameters);
        $this->seeStatusCode(201);
        $this->seeInDatabase('courses', compact('title'));
    }

    public function testShowAllCourses(){
        $this->get('/courses');
        $this->seeStatusCode(200);
    }

    public function testUpdateCourse(){
        $title = \Illuminate\Support\Str::random(20);
        $parameters = [
            'title' => $title,
            'subtitle' => 'PHP 8',
            'description' => 'Um curso legal sobre nao sei o que mas aborda ocurso sei la sei la sei la sei la sei la sei la sei la se',
            'startedAt' => \Carbon\Carbon::now(),
            'active' => '1',
        ];

        $this->put('courses/1', $parameters);
        $this->seeStatusCode(200);
        $this->seeInDatabase('courses', compact('title'));
    }

    public function testDestroyCourse(){
        $id = 12;
        $this->delete('courses/'. $id);
        $this->seeStatusCode(200);
    }

    public function testShowCourse(){
        $this->get('/courses/5');
        $this->seeStatusCode(200);
    }

    public function testFindCourse(){
        $this->call('GET', '/courses', ['title' => 'PHP']);
        $this->seeStatusCode(200);
    }
}
