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
        $search = $request->input('search');
        $nombre = $request->input('nombre');
        $paterno = $request->input('paterno');
        $materno = $request->input('materno');
        $institucion = $request->input('institucion');

        $id_evento = $request->input('id_evento');
        $user = Asistente::select('asistentes.id', 'asistentes.nombre', 'asistentes.paterno', 'asistentes.materno', 'asistentes.ci', 'asistentes.complemento', 'asistentes.telefono', 'asistentes.email', 'asistentes.institucion', 'asistentes.llave', 'asistentes.ingreso', 'asistentes.apoyo_didactico', 'asistentes.refrigerio', 'asistentes.id_tipo_asistente', 'asiste_evento.id_asistente', 'asiste_evento.id_evento', 'tipo_asistente.nombre AS tipo_asistente')
                            ->leftJoin('asiste_evento', 'asistentes.id', '=', 'asiste_evento.id_asistente')
                            ->leftJoin('tipo_asistente', 'id_tipo_asistente', '=', 'tipo_asistente.id')
                            ->where( 'asistentes.ci', 'LIKE', $search . '%' )

                            ->where( 'asistentes.nombre', 'LIKE', $nombre . '%' )
                            ->where( 'asistentes.paterno', 'LIKE', $paterno . '%' )
                            ->where( 'asistentes.materno', 'LIKE', $materno . '%' )
                            ->where( 'asistentes.institucion', 'LIKE', $institucion . '%' )

                            ->where( 'asiste_evento.id_evento', '=', $id_evento )
                            ->orderBy('asistentes.id', 'desc')
                            ->paginate (10)
                            ->setPath ( '' );
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
        DB::table('asiste_evento')->where('id_asistente', $id)->delete();

        return response()->json([
            'res'=>true,
            'message'=>'Asistente eliminado correctamente'
        ], 200);
    }
}
