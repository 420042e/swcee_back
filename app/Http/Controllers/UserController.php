<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('search');
        $user = User::select('users.id', 'nombre', 'ap_paterno', 'ap_materno', 'email', 'pass', 'estado', 'rol', 'nombre_rol')
                        ->leftJoin('rol', 'users.rol', '=', 'rol.id')
                        ->where('nombre', 'LIKE', '%' . $q . '%')
                        ->orderBy('users.id', 'desc')
                        ->paginate (10)->setPath ( '' );
        $pagination = $user->appends ( array (
            'search' => $request->input('search')
            ) );
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['pass']=Hash::make($request->pass);
        User::create($input);
        $id = DB::getPdo()->lastInsertId();

        return response()->json([
            'id'=>$id,
            'res'=>true,
            'message'=>'Usuario creado correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$id = $request->input('search');
        $user = User::select('users.id', 'nombre', 'ap_paterno', 'ap_materno', 'email', 'pass', 'estado', 'rol')->where( 'id', '=', '' . $id . '' )->get ();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        //$input['pass']=Hash::make($request->pass);
        $affected = DB::table('users')->where('id', $id)->update($input);
        $user = User::select('users.id', 'nombre', 'ap_paterno', 'ap_materno', 'email', 'pass', 'estado', 'rol', 'nombre_rol')
                        ->leftJoin('rol', 'users.rol', '=', 'rol.id')
                        ->where( 'users.id', '=', '' . $id . '' )->get ();

        return response()->json([
            'res'=>true,
            'message'=>'Usuario actualizado correctamente',
            'user'=>$user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json([
            'res'=>true,
            'message'=>'Usuario eliminado correctamente'
        ], 200);
    }

    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if(!is_null($user) && Hash::check($request->pass, $user->pass))
        {
            $token = $user->createToken('usuarios')->accessToken;

            return response()->json([
                'id'=>$user->id,
                'nombre'=>$user->nombre,
                'rol'=>$user->rol,
                'estado'=>$user->estado,
                'res'=>true,
                'token'=>$token,
                'message'=>'Bienvenido al sistema'
            ],200);
        }
        else
        {
            return response()->json([
                'res'=>false,
                'message'=>'Cuenta o password incorrectos'
            ],200);
        }
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens->each(function($token, $key){
            $token->delete();
        });
        $user->save();

        return response()->json([
            'res'=>true,
            'message'=>'Adios',
        ],200);
    }

    public function verificarPass(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if(!is_null($user) && Hash::check($request->pass, $user->pass))
        {
            return response()->json([
                'res'=>true,
                'message'=>'La contraseña es correcta'
            ],200);
        }
        else
        {
            return response()->json([
                'res'=>false,
                'message'=>'Cuenta o password incorrectos'
            ],200);
        }
    }
}
