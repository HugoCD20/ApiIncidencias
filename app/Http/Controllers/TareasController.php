<?php

namespace App\Http\Controllers;

use App\Http\Resources\TareaResource;
use App\Models\Tareas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas=Tareas::with('user','incidencia')->get();

        if($tareas->isEmpty()){
            $data=[
                "message"=> "No hay tareas registradas",
                "status"=> 400
            ];
            return response()->json($data,400);
        }
        return TareaResource::collection($tareas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'user_id'=>'required|integer',
            'incidencia_id'=>'required|integer',
            'titulo'=>'required|string|max:255',
            'descripcion'=>'required|string|max:255',
            'estado'=>'required|string|max:255',
        ]);
        if($validator->fails()){
            $data=[
                'message'=>'Datos invalidos',
                'error'=> $validator->errors()->first(),
                'status'=> 400
            ];
            return response()->json($data,500);
        }
        $tarea=Tareas::create([
            'user_id'=> $request->user_id,
            'incidencia_id'=> $request->incidencia_id,
            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion,
            'estado'=>$request->estado
        ]);
        if(!$tarea){
            $data=[
                'message'=>'error al crear la tarea',
                'status'=>500
            ];
            return response()->json($data,500);
        }
        $data=[
            'message'=> 'Tarea registrada correctamente',
            'tarea'=> $tarea,
            'status'=> 201
        ];
        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {        
        $tarea=Tareas::with('user','incidencia')->find($id);
        if(!$tarea){
            $data=[
                'message'=>'tarea no encontrada',
                'status'=>400
            ];
            return response()->json($data,400);
        }
        $data=[
            'message'=>'Tarea encontrada',
            'status'=>201,
            'Tarea'=>new TareaResource($tarea)
        ];
        return response()->json($data,201);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(), [
            'user_id'=>'nullable|integer',
            'incidencia_id'=>'nullable|integer',
            'titulo'=>'nullable|string|max:255',
            'descripcion'=>'nullable|string|max:255',
            'estado'=>'nullable|string|max:255',
        ]);
        if($validator->fails()){
            $data=[
                "message"=>"ha ocurrido un error al intentar actua",
                "error"=>$validator->errors()->first(),
                "status"=> 200
            ];
            return response()->json($data,200);
        }
        $tarea=Tareas::with("user","incidencia")->find($id);
        if(!$tarea){
            $data=[
                "message"=> "La tarea no ha sido encotrada",
                "status"=> 200
            ];
            return response()->json($data,200);
        }
        if($request->has('titulo')){
            $tarea->titulo=$request->input('titulo');
        }
        if($request->has('descripcion')){
            $tarea->descripcion=$request->input('descripcion');
        }
        if($request->has('estado')){
            $tarea->estado=$request->input('estado');
        }
        $tarea->save();
        $data=[
            'message'=>'Operación exitosa',
            'status'=> 201,
            'tarea'=>new TareaResource($tarea)
        ];
        return response()->json($data,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarea=Tareas::find($id);
        if(!$tarea){
            $data=[
                'message'=> 'tarea no encontrada',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        $tarea->delete();
        $data=[
            'message'=> 'Tarea eliminada exitosamente',
            'status'=> 201
        ];
        return response()->json($data,201);
    }
}
