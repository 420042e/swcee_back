<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use App\Models\Membrete;

class CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return Certificado::orderBy('id', 'desc')->get();

        $q = $request->input('search');
        $user = Certificado::where( 'nombre', 'LIKE', '%' . $q . '%' )->orderBy('id', 'desc')->paginate (10)->setPath ( '' );
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
        Certificado::create($input);
        $id = DB::getPdo()->lastInsertId();
        return response()->json([
            'id'=>$id,
            'res'=>true,
            'message'=>'Certificado creado correctamente'
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
        $certificado = Certificado::where( 'id', '=', '' . $id . '' )->get();

        //$user = Membrete::where( 'id', '=', '' . $certificado->id_membrete . '' )->get();
        //$user = base64_encode(file_get_contents(public_path().'/imgs/'.$fileName));
        //$certificado = $user->merge($certificado);

        return $certificado;
    }

    public function certificado64($id)
    {
        $certificado = Certificado::leftJoin('membrete', 'id_membrete', '=', 'membrete.id')->where( 'certificados.id', '=', $id )->get();
        if($certificado[0]->nombre == null)
        {
            /*if($certificado[0]->id_membrete == 0)
            {
                $base64 = base64_encode(file_get_contents(public_path().'/default/plantilla_inicial.jpg'));
                $size = getimagesizefromstring(file_get_contents(public_path().'/default/plantilla_inicial.jpg'));
            }
            else
            {
                $base64 = base64_encode(file_get_contents(public_path().'/membretes/'.$certificado[0]->nombre));
                $size = getimagesizefromstring(file_get_contents(public_path().'/membretes/'.$certificado[0]->nombre));
            }*/
            $base64 = base64_encode(file_get_contents(public_path().'/default/plantilla_inicial.jpg'));
            $size = getimagesizefromstring(file_get_contents(public_path().'/default/plantilla_inicial.jpg'));
            $certificado[0]->base64 = $base64;
            $certificado[0]->anchoImg = $size[0];
            $certificado[0]->altoImg = $size[1];

            /*$certificado[0]->base64 = "";
            $certificado[0]->anchoImg = "";
            $certificado[0]->altoImg = "";*/
        }
        else
        {
            
            $base64 = base64_encode(file_get_contents(public_path().'/membretes/'.$certificado[0]->nombre));
            $certificado[0]->base64 = $base64;
            $size = getimagesizefromstring(file_get_contents(public_path().'/membretes/'.$certificado[0]->nombre));
            $certificado[0]->anchoImg = $size[0];
            $certificado[0]->altoImg = $size[1];
        }
        return $certificado;
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
        $affected = DB::table('certificados')->where('id', $id)->update($input);
        return response()->json([
            'res'=>true,
            'message'=>'Certificado actualizado correctamente'
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
        Certificado::destroy($id);
        return response()->json([
            'res'=>true,
            'message'=>'Certificado eliminado correctamente'
        ], 200);
    }
}
