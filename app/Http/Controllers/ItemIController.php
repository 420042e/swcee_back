<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemsI;
use Illuminate\Support\Facades\DB;

class ItemIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ItemsI::all();
    }

    private function cargarArchivo($file)
    {
        $nombreArchivo = time().".".$file->getClientOriginalExtension();
        $file->move(public_path('itemsi'), $nombreArchivo);
        return $nombreArchivo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$input = $request->all();
        if($request->has('nombre'))
            $input['nombre']=$this->cargarArchivo($request->nombre);

        ItemsI::create($input);
        $id = DB::getPdo()->lastInsertId();
        return response()->json([
            'id'=>$id,
            'res'=>true,
            'message'=>'Imagen guardada correctamente'
        ], 200);*/

        $input = $request->all();
        DB::table('itemsi')->where('id_certificado', $input[0]['id_certificado'])->delete();
        foreach ($input as $key => $value) {
            ItemsI::create($value);
        }
        return response()->json([
            'res'=>true,
            'message'=>'ItemsI creados correctamente'
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
        /*$membrete = ItemsI::select('nombre')->where( 'id_certificado', '=', $id )->get ();
        $fileName = $membrete->first()->nombre;

        $filePath = public_path().'/itemsi/'.$fileName;
        return response()->file($filePath);*/
        
        $user = ItemsI::where( 'id_certificado', '=', '' . $id . '' )->get ();
        return $user;
    }

    public function itemsi64($id)
    {
        $itemsi = ItemsI::leftJoin('imgs', 'itemsi.nombre', '=', 'imgs.id')->where( 'id_certificado', '=', $id )->get ();
        for ($i = 0; $i < count($itemsi); $i++) {
            $base64 = base64_encode(file_get_contents(public_path().'/imgs/'.$itemsi[$i]->nombre));
            $itemsi[$i]->base64 = $base64;
            $size = getimagesizefromstring(file_get_contents(public_path().'/imgs/'.$itemsi[$i]->nombre));
            $itemsi[$i]->anchoImg = $size[0];
            $itemsi[$i]->altoImg = $size[1];
        }



        /*$base64 = base64_encode(file_get_contents(public_path().'/imgs/'.$itemsi[0]->nombre));
        $itemsi[0]->base64 = $base64;
        $size = getimagesizefromstring(file_get_contents(public_path().'/imgs/'.$itemsi[0]->nombre));
        $itemsi[0]->anchoImg = $size[0];
        $itemsi[0]->altoImg = $size[1];*/

        /*$certificado = Certificado::where( 'id', '=', $id )->get();
        if($certificado[0]->id_membrete != 0)
        {
            $membrete = Membrete::where( 'id', '=', $id )->get();
            $base64 = base64_encode(file_get_contents(public_path().'/membretes/'.$membrete[0]->nombre));
            $certificado[0]->base64 = $base64;
            $size = getimagesizefromstring(file_get_contents(public_path().'/membretes/'.$membrete[0]->nombre));
            $certificado[0]->anchoImg = $size[0];
            $certificado[0]->altoImg = $size[1];
        }
        else
        {
            $certificado[0]->base64 = "";
            $certificado[0]->anchoImg = "";
            $certificado[0]->altoImg = "";
        }*/

        /*$base64 = base64_encode(file_get_contents(public_path().'/membretes/'.$membrete[0]->nombre));
        $certificado[0]->base64 = $base64;
        $size = getimagesizefromstring(file_get_contents(public_path().'/membretes/'.$membrete[0]->nombre));
        $certificado[0]->anchoImg = $size[0];
        $certificado[0]->altoImg = $size[1];*/

        return $itemsi;
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
