<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\Input;

class CourseController extends Controller
{

    private $course;


    public function __construct(Course $course){
        $this->course = $course;
    }

    public function index(){
        try {
            return response()->json($this->course->paginate(15), 200);
        } catch (\Exception $e){
            return response()->json(['error' => ['Erro ao acessar os cursos']], 500);
        }
    }

    public function store(Request $request){
        try {
            $courseValidated = $this->validate($request, [
                'title' => 'required|min:3|max:80',
                'subtitle' => 'required|min:3|max:80',
                'description' => 'required|min:3|max:1000',
                'startedAt' => 'required|date',
                'active' => 'required|boolean',
            ]);

            $course = $this->course->create($courseValidated);
            $message = 'Curso cadastrado com sucesso!';

            return response()->json(compact('course', 'message'), 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => [$e->response->getContent()]], $e->status);
        } catch (\Exception $e){
            return response()->json(['error' => ['Erro ao cadastrar curso']], 500);
        }

    }

    public function update(Request $request, int $id){
        try {
            $course = $this->course->findOrFail($id);

            $courseValidated = $this->validate($request, [
                'title' => 'required|min:3|max:80',
                'description' => 'required|min:3|max:1000',
                'subtitle' => 'required|min:3|max:80',
                'startedAt' => 'required|date',
                'active' => 'required|boolean',
            ]);

            $course->update($courseValidated);

            $message = 'Curso atualizado com sucesso!';

            return response()->json(compact('course', 'message'), 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => [$e->response->getContent()]], $e->status);
        } catch (\Exception $e){
            return response()->json(['error' => ['Erro ao cadastrar curso']], 500);
        }
    }

    public function destroy(int $id){
        try {
            $this->course->findOrFail($id)->delete();
            $message = 'Curso deletado com sucesso!';
            return response()->json(compact('message'), 200);
        } catch (\Exception $e){
            if ($e instanceof ModelNotFoundException){
                return response()->json(['error' => 'Curso não encontrado'], 404);
            }
            return response()->json(['error' => ['Erro ao cadastrar curso']], 500);
        }
    }

    public function show(int $id){
        try {
            $course = $this->course->findOrFail($id);
            return response()->json(compact('course'), 200);
        } catch (\Exception $e){
            if ($e instanceof ModelNotFoundException){
                return response()->json(['error' => ['Curso não encontrado']], 404);
            }
            return response()->json(['error' => ['Erro ao procuras curso']], 500);
        }
    }

    public function find(Request $request){
        try {
            $courses =  $this->course->where('title', 'LIKE', '%'. $request->input('title') .'%')->get();
            if (empty($courses)){
                return response()->json(['error' => ['Nenhum curso encontrado']], 404);
            }
            return response()->json(compact('courses'), 200);
        } catch (\Exception $e){
            return response()->json(['error' => [$e->getMessage()]], 500);
        }
    }

}
