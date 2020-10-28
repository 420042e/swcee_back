<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;
use Illuminate\Support\Facades\DB;

class ConfirmacionCIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('busqueda');
        $id_evento = $request->input('id_evento');
        $user = Asistente::leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')->where( 'ci', '=', $q )->where( 'asiste_evento.id_evento', '=', $id_evento )->get();
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
        //$input = $request->all();
        $affected = DB::table('asistentes')->where('id', $id)->update(array('ingreso' => 1));
        return response()->json([
            'res'=>true,
            'message'=>'Asistente confirmado correctamente'
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
        //
    }
}
