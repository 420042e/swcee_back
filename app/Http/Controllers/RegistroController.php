<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Asistente;
use App\Models\AsisteEvento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        $event = Evento::select('eventos.id', 'nombre_evento', 'estado')->leftJoin('categoria', 'eventos.tipo', '=', 'categoria.id')->where( 'eventos.id', $id )->orderBy('eventos.id', 'desc')->get ();
        return $event;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
