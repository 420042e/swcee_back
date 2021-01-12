<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_evento = $request->input('id_evento');
        $ingreso = $request->input('ingreso');
        $q = $request->input('search');

        $apoyo_didactico = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                ->where( 'apoyo_didactico', '=', '1' )
                ->where( 'asiste_evento.id_evento', '=', $id_evento )
                ->get ();
        $refrigerio = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                ->where( 'refrigerio', '=', '1' )
                ->where( 'asiste_evento.id_evento', '=', $id_evento )
                ->get ();

        $asistio = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                ->where( 'ingreso', '=', '1' )
                ->where( 'asiste_evento.id_evento', '=', $id_evento )
                ->get ();
        $no_asistio = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                ->where( 'ingreso', '=', '0' )
                ->where( 'asiste_evento.id_evento', '=', $id_evento )
                ->get ();
        $user = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                ->where( 'asistentes.ci', 'LIKE', '%' . $q . '%' )
                ->where( 'ingreso', '=', $ingreso )
                ->where( 'asiste_evento.id_evento', '=', $id_evento )
                ->orderBy('asistentes.id', 'desc')
                ->paginate(10)->setPath ( '' );
        $custom = collect(['apoyo_didactico' => $apoyo_didactico->count(), 'refrigerio' => $refrigerio->count(), 'asistio' => $asistio->count(), 'no_asistio' => $no_asistio->count() ]);
        $user = $custom->merge($user);

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
