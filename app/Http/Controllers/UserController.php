<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();
        if(empty($users)){
            $data=[
                "message"=>"No se encontro ningun usuario",
                "status"=>200
            ];
            return response()->json($data,200);
        }
        return response()->json($users,201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "email"=>"required|string|max:255|email",
            "role"=>"required|string|max:255",
            "password"=>"required|string|max:255",
        ]);
        if($validator->fails()){
            $data=[
                'message'=>'ha ocurrido un error',
                "Error"=> $validator->errors()->first(),
                "Status"=> 400
            ];
            return response()->json($data,400);

        }
        $user=User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "role"=>$request->role,
            "password"=>$request->password,
        ]);
        if(!$user){
            $data=[
                "message"=>"Error al crear al estudiante",
                "Status"=>500
            ];
            return response()->json($data,500);
        }
        return response()->json($user,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}