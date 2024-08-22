<?php

namespace App\Http\Controllers;

use App\Models\asignaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AsignacionResource;
use App\Http\Resources\IncidenciaResource;

class AsignacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $asignaciones = Asignaciones::with('user', 'incidencia')->get();
    
    if ($asignaciones->isEmpty()) {
        $data = [
            'message' => 'No hay asignaciones registradas',
            'status' => 400
        ];
        return response()->json($data, 400);
    }
    
    return AsignacionResource::collection($asignaciones);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'user_id'=>'required|integer',
            'incidencia_id'=>'required|integer'
        ]);
        if($validator->fails()){
            $data=[
                'message'=>'ha ocurrido un error en la validacion de los datos',
                'error'=> $validator->errors()->first(),
                'status'=>200
            ];
            return response()->json($data,200);
        }

        $asignacion=asignaciones::create([
            'user_id'=> $request->user_id,
            'incidencia_id'=> $request->incidencia_id,
        ]);
        if(!$asignacion){
            $data=[
                'message'=> 'No se ha podido crear la asignacion',
                'status'=>200
            ];
            return response()->json($data,200);
        }
        $data=[
            'message'=> 'Asignacion creada correctamente',
            'asignacion'=> $asignacion,
            'status'=> 201
        ];
        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asignacion=asignaciones::with('user','incidencia')->findOrFail($id);
        if(!$asignacion){
            $data=[
                'message'=> 'Asignacion no encontrada',
                'status'=> 400
            ];
            return response()->json($data,400);
        }
        $data=[
            'message'=> 'Asignacion encontrada correctamente',
            'Asignacion'=> new AsignacionResource($asignacion),
            'status'=> 200
        ];
        return response()->json($data,200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'user_id'=> 'nullable|integer',
            'incidencia_id'=> 'nullable|integer'
        ]);
        if($validator->fails()){
            $data=[
                'message'=>'ha ocurrido un error al validar los datos',
                'error'=> $validator->errors()->first(),
                'status'=> 400
            ];
            return response()->json($data,400);
        }

        $asignacion=asignaciones::findOrFail($id);

        if(!$asignacion){
            $data=[
                'message'=> 'ha ocurrido un error al procesar la solicitud',
                'status'=>500
            ];
            return response()->json($data,500);
        }

        if($request->has('user_id')){
            $asignacion->user_id=$request->input('user_id');
        }
        if($request->has('incidencia_id')){
            $asignacion->incidencia_id=$request->input('incidencia_id');
        }

        $asignacion->save();
        $asignacion=asignaciones::with('user','incidencia')->findOrFail($id);
        $data=[
            'message'=> 'Asignacion actualizada correctamente',
            'asignacion'=> new AsignacionResource($asignacion),
            'status'=> 200
        ];
        return response()->json($data,200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asignacion=asignaciones::findOrFail($id);
        if(!$asignacion){
            $data=[
                'message'=> 'no se ha encontra la asignacion',
                'status'=> 400
            ];
            return response()->json($data,400);
        }
        $asignacion->delete();
        $data=[
            'message'=> 'asignacion eliminada correctamente',
            'status'=> 200
        ];
        return response()->json($data,200);
    }
}
