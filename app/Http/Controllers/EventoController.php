<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EmailRegistro;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return Evento::all();
        
        /*$eventos = DB::table('eventos')->paginate(10);
        return $eventos;*/
        $q = $request->input('search');
        /*if($q != "")
        { 
            $user = Evento::where ( 'nombre_evento', 'LIKE', '%' . $q . '%' )->paginate (10)->setPath ( '' );
            $pagination = $user->appends ( array (
                'q' => $request->input('q')
                ) );
        }*/
        $user = Evento::select('eventos.id', 'nombre_evento', 'lugar', 'fecha', 'hora', 'estado', 'tipo', 'descripcion', 'nombre')->leftJoin('categoria', 'eventos.tipo', '=', 'categoria.id')->where( 'nombre_evento', 'LIKE', '%' . $q . '%' )->orderBy('eventos.id', 'desc')->paginate (10)->setPath ( '' );
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
        $evento = Evento::create($input);

        $emailRegistro = new EmailRegistro();
        $emailRegistro->titulo = 'Gracias por su registro';
        $emailRegistro->contenido = 'Gracias por registrarte';
        $emailRegistro->id_evento = $evento->id;
        $emailRegistro->save();
        $id = DB::getPdo()->lastInsertId();

        return response()->json([
            'res'=>true,
            'message'=>'Evento creado correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        $event = Evento::leftJoin('categoria', 'eventos.tipo', '=', 'categoria.id')->where( 'eventos.id', $evento->id )->orderBy('eventos.id', 'desc')->get ();
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
        $input = $request->all();
        $affected = DB::table('eventos')->where('id', $id)->update($input);
        $event = Evento::select('eventos.id', 'nombre_evento', 'lugar', 'fecha', 'hora', 'estado', 'tipo', 'descripcion', 'nombre')->leftJoin('categoria', 'eventos.tipo', '=', 'categoria.id')->where( 'eventos.id', $id )->orderBy('eventos.id', 'desc')->get ();
        return response()->json([
            'res'=>true,
            'message'=>'Evento actualizado correctamente',
            'evento'=>$event
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
