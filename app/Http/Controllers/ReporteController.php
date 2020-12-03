<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;

class ReporteController extends Controller
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
        $ingreso = $request->input('ingreso');
        $user = Asistente::select('asistentes.id', 'asistentes.nombre', 'asistentes.paterno', 'asistentes.materno', 'asistentes.ci', 'asistentes.complemento', 'asistentes.telefono', 'asistentes.email', 'asistentes.institucion', 'asistentes.llave', 'asistentes.ingreso', 'asistentes.id_tipo_asistente', 'asiste_evento.id_asistente', 'asiste_evento.id_evento', 'tipo_asistente.nombre AS tipo_asistente')
                            ->leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                            ->leftJoin('tipo_asistente', 'id_tipo_asistente', '=', 'tipo_asistente.id')
                            ->where( 'asistentes.ingreso', '=', $ingreso )
                            ->where( 'asiste_evento.id_evento', '=', $id_evento )
                            ->orderBy('asistentes.id', 'desc')->get ();
            
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
        $user = Asistente::select('asistentes.id', 'asistentes.nombre', 'asistentes.paterno', 'asistentes.materno', 'asistentes.ci', 'asistentes.complemento', 'asistentes.telefono', 'asistentes.email', 'asistentes.institucion', 'asistentes.llave', 'asistentes.ingreso', 'asistentes.id_tipo_asistente', 'asiste_evento.id_asistente', 'asiste_evento.id_evento', 'tipo_asistente.nombre AS tipo_asistente')
                            ->leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                            ->leftJoin('tipo_asistente', 'id_tipo_asistente', '=', 'tipo_asistente.id')
                            ->where( 'asistentes.id', '=', $id )->get ();
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
