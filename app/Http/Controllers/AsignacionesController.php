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
            'status' => 200
        ];
        return response()->json($data, 200);
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
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        $data=[
            'message'=> 'Asignacion encontrada correctamente',
            'Asignacion'=> new AsignacionResource($asignacion),
            'status'=> 201
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(asignaciones $asignaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, asignaciones $asignaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(asignaciones $asignaciones)
    {
        //
    }
}
