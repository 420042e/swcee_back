<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;

class CertificadoController extends Controller
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
        $user = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')->where( 'asistentes.ingreso', '=', '1' )->where( 'asiste_evento.id_evento', '=', $id_evento )->orderBy('asistentes.id', 'desc')->get ();
            
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
