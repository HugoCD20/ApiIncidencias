<?php

namespace App\Http\Controllers;

use App\Models\Incidencias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidenciasController extends Controller
{
    public function index(){
        $incidencias=Incidencias::all();
        if($incidencias->isEmpty()){
            $data=[
                'message'=>'No hay incidencias registradas',
                'Status'=>200
            ];
            return response()->json($data,200);
        }
        return response()->json($incidencias,201);
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
        $incidencia=Incidencias::find($id);
        if(!$incidencia){
            $data=[
                'message'=>'no se encontró la incidencia',
                'Status'=>200
            ];
            return response()->json($data,200);
        }
        $data=[
            'Incidencia'=>$incidencia,
            'Status'=>201
        ];
        return response()->json($data,201);
    }
}
