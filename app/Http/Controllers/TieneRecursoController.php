<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TieneRecurso;
use App\Models\Recurso;
use App\Models\AsisteEvento;
use Illuminate\Support\Facades\DB;

class TieneRecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return TieneRecurso::orderBy('id', 'desc')->get();

        $id_evento = $request->input('id_evento');
        $user = TieneRecurso::select('tiene_recurso.id', 'tiene_recurso.id_recurso', 'recurso.nombre', 'tiene_recurso.cantidad', 'tiene_recurso.precio')
                            ->leftJoin('recurso', 'recurso.id', '=', 'tiene_recurso.id_recurso')
                            ->where( 'tiene_recurso.id_evento', '=', $id_evento )
                            ->orderBy('tiene_recurso.id', 'desc')
                            ->paginate (10)
                            ->setPath ( '' );

        $total = AsisteEvento::where('asiste_evento.id_evento', '=', $id_evento)->get()->count();
        $custom = collect(['registrados' => $total]);
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
        $input = $request->all();
        $input['id_recurso']=$request->id_recurso;
        $input['id_evento']=$request->id_evento;
        $input['cantidad']=$request->cantidad;
        $asistente = TieneRecurso::create($input);

        $id = DB::getPdo()->lastInsertId();
        $recurso = TieneRecurso::select('tiene_recurso.id', 'tiene_recurso.id_recurso', 'recurso.nombre', 'tiene_recurso.cantidad', 'tiene_recurso.precio')
                            ->leftJoin('recurso', 'recurso.id', '=', 'tiene_recurso.id_recurso')
                            ->where( 'tiene_recurso.id', '=', $id )
                            ->get();

        return response()->json([
            'id'=>$id,
            'recurso'=>$recurso,
            'res'=>true,
            'message'=>'Recurso asignado a evento correctamente'
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
        $input = $request->all();
        //$input['pass']=Hash::make($request->pass);
        $affected = DB::table('tiene_recurso')->where('id', $id)->update($input);
        $recurso = TieneRecurso::select('tiene_recurso.id', 'tiene_recurso.id_recurso', 'recurso.nombre', 'tiene_recurso.cantidad', 'tiene_recurso.precio')
                            ->leftJoin('recurso', 'recurso.id', '=', 'tiene_recurso.id_recurso')
                            ->where( 'tiene_recurso.id', '=', $id )
                            ->get();

        return response()->json([
            'res'=>true,
            'message'=>'Recurso asignado a evento actualizado correctamente',
            'recurso'=>$recurso
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
        TieneRecurso::destroy($id);

        return response()->json([
            'res'=>true,
            'message'=>'Recurso eliminado correctamente'
        ], 200);
    }
}
