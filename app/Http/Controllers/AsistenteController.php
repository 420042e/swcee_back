<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;
use App\Models\AsisteEvento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AsistenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('search');
        $id_evento = $request->input('id_evento');
        $user = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')->where( 'nombre', 'LIKE', '%' . $q . '%' )->where( 'asiste_evento.id_evento', '=', $id_evento )->orderBy('asistentes.id', 'desc')->paginate (10)->setPath ( '' );
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
        $input['llave']=Hash::make($request->ci);
        $asistente = Asistente::create($input);

        $asisteEvento = new AsisteEvento();
        $asisteEvento->id_asistente = $asistente->id;
        $asisteEvento->id_evento = $request->input('id_evento');
        $asisteEvento->save();
        $id = DB::getPdo()->lastInsertId();

        return response()->json([
            'id'=>$id,
            'res'=>true,
            'message'=>'Asistente creado correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Asistente $asistente)
    {
        return $asistente;
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
        $affected = DB::table('asistentes')->where('id', $id)->update($input);
        return response()->json([
            'res'=>true,
            'message'=>'Registro actualizado correctamente'
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
        Asistente::destroy($id);
        return response()->json([
            'res'=>true,
            'message'=>'Asistente eliminado correctamente'
        ], 200);
    }
}
