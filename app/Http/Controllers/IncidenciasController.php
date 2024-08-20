<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncidenciaResource;
use App\Models\Incidencias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidenciasController extends Controller
{
    public function index(){
        $incidencias=Incidencias::with('user')->get();
        if($incidencias->isEmpty()){
            $data=[
                'message'=>'No hay incidencias registradas',
                'Status'=>200
            ];
            return response()->json($data,200);
        }
        return IncidenciaResource::collection($incidencias);
    }
    public function store(request $request){

        $validator=Validator::make($request->all(),[
            'user_id'=> 'required|integer|max:255',
            'titulo'=> 'required|string|max:255',
            'descripcion'=> 'required|string|max:255',
            'evidencias'=> 'required|string|max:255',
            'etapa'=> 'required|string|max:255',
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'ha ocurrido un error al registrar una incidencia',
                'error'=> $validator->errors()->first(),
                'Status'=>200
            ];
            return response()->json($data,200);
        }
        $incidencia=Incidencias::create([
            'user_id'=> $request->user_id,
            'titulo'=> $request->titulo,
            'descripcion'=> $request->descripcion,
            'evidencias'=> $request->evidencias,
            'etapa'=> $request->etapa,
        ]);
        if(!$incidencia){
            $data=[
                'message'=>'ha ocurrido un error al registrar una incidencia',
                'Status'=>200
            ];
        }
        $data=[
            'message'=>'Incidencia registrada',
            'incidencia'=>$incidencia,
            'status'=>201
        ];
        return response()->json($data,201);
    }
    public function show($id){
        $incidencia=Incidencias::with('user')->find($id);
        if(!$incidencia){
            $data=[
                'message'=>'no se encontró la incidencia',
                'Status'=>200
            ];
            return response()->json($data,200);
        }
        $data=[
            'Incidencia'=>new IncidenciaResource($incidencia),
            'Status'=>201
        ];
        return response()->json($data,200);
    }

    public function update(Request $request, string $id ){

        $validator=Validator::make($request->all(),[
            'titulo'=>'nullable|string|max:255',
            'descripcion'=>'nullable|string|max:255',
            'evidencias'=>'nullable|string|max:255',
            'etapa'=>'nullable|string|max:255',
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'ha ocurrido un error al validar los atos',
                'Error'=>$validator->errors()->first(),
                'status'=>200
            ];
            return response()->json($data,200);
        }

        $incidencia=Incidencias::with('user')->find($id);
        if(!$incidencia){
            $data=[
                'message'=>'No se ha encontrado la incidencia',
                'status'=>200
            ];
            return response()->json($data,200);
        }

        if($request->has('titulo')){
            $incidencia->titulo=$request->input('titulo');
        }
        if($request->has('descripcion')){
            $incidencia->descripcion=$request->input('descripcion');
        }
        if($request->has('evidencias')){
            $incidencia->evidencias=$request->input('evidencias');
        }
        if($request->has('etapa')){
            $incidencia->etapa=$request->input('etapa');
        }

        $incidencia->save();
        $data=[
            'message'=>"Incidencia actualizada correctamente",
            'incidencia'=>new IncidenciaResource($incidencia),
            'status'=>201
        ];
        return response()->json($data,201);

    }
    public function destroy(string $id){
        $incidencia=Incidencias::find($id);
        if(!$incidencia){
            $data=[
                'message'=>'No se ha encontrado esta incidencia',
                'status'=>200
            ];
            return response()->json($data,200);
        }
        $incidencia->delete();
        $data=[
            'message'=>'Incidencia eliminada correctamente',
            'status'=>201
        ];
        return response()->json($data,201);
    }
}
