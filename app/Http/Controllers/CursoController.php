<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
class CursoController extends Controller
{
    private $curso;

    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
    }

    public function index()
    {
        $cursos =  $this->curso->paginate(10);

        return response()
            ->json(
                [
                    'data' =>
                        [
                            'cursos' => $cursos
                        ]
                ]);
    }

    public function show(int $id)
    {
        $curso = $this->curso->findOrFail($id);

        return response()
            ->json(
                [
                    'curso' => $curso
                ]);
    }

    public function store(Request $request)
    {
        $curso = $this->curso->create($request->all());

        return response()
            ->json(
                [
                    'data' =>
                        [
                            'message' => 'Curso foi criado com sucesso!',
                            'curso' => $curso
                        ]
                ]
            );
    }

    public function update(int $id, Request $request)
    {
        $curso = $this->curso->find($id);

        $curso->update($request->all());

        return response()
            ->json(
                [
                    'data' =>
                        [
                            'message' => 'Curso foi atualizado com sucesso!',
                            'curso' => $curso
                        ]
                ]
            );
    }


    public function destroy(int $id)
    {
        $curso = $this->curso->find($id);

        $curso->delete();

        return response()
            ->json([
                'data' => [
                    'message' => 'Curso foi removido com sucesso!'
                ]
            ]);
    }
}
