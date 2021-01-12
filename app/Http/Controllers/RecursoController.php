<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurso;
use Illuminate\Support\Facades\DB;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Recurso::orderBy('id', 'desc')->get(); 

        $recurso = Recurso::select('recurso.id', 'recurso.nombre', 'tipo_recurso.nombre AS tipo_recurso', 'tipo_recurso.id AS id_tipo_recurso')
                            ->leftJoin('tipo_recurso', 'recurso.tipo', '=', 'tipo_recurso.id')
                            //->where( 'recurso.tipo', '=', 'tipo_recurso.id' )
                            ->orderBy('id', 'desc')
                            ->get();

        return $recurso;
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
        Recurso::create($input);
        $id = DB::getPdo()->lastInsertId();

        $recurso = Recurso::select('recurso.nombre', 'tipo_recurso.nombre AS tipo_recurso', 'tipo_recurso.id')
                            ->leftJoin('tipo_recurso', 'recurso.tipo', '=', 'tipo_recurso.id')
                            ->where( 'recurso.id', '=', $id )
                            ->get();

        return response()->json([
            'id'=>$id,
            'res'=>true,
            'message'=>'Tipo de recurso creado correctamente',
            'user'=>$recurso
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
        $affected = DB::table('recurso')->where('id', $id)->update($input);

        $recurso = Recurso::select('recurso.nombre', 'tipo_recurso.nombre AS tipo_recurso', 'tipo_recurso.id')
                            ->leftJoin('tipo_recurso', 'recurso.tipo', '=', 'tipo_recurso.id')
                            ->where( 'recurso.id', '=', $id )
                            ->get();

        return response()->json([
            'res'=>true,
            'message'=>'Tipo de recurso actualizado correctamente',
            'user'=>$recurso
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
        Recurso::destroy($id);
        return response()->json([
            'res'=>true,
            'message'=>'Tipo de recurso eliminado correctamente'
        ], 200);
    }
}
