<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemQR;
use Illuminate\Support\Facades\DB;

class ItemQRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function generarQR64(Request $request)
    {
        $input = $request->all();
        $id_evento = $input['id_evento'];
        $id_certificado = $input['id_certificado'];

        $itemqr = ItemQR::where( 'id_certificado', '=', $id_certificado )->get ();

        for ($i = 0; $i < count($itemqr); $i++) {
            $contenido = "https://swcee.com/archivos-evento/".$id_evento;
            $result_qr_content_in_png = \QrCode::format('png')
                    ->size(200)
                    ->generate($contenido);
            $base64 = base64_encode($result_qr_content_in_png);
            $itemqr[$i]->base64 = $base64;
        }

        /*$contenido = "https://swcee.com/archivo-evento/".$id;
        $result_qr_content_in_png = \QrCode::format('png')
                ->size(200)
                ->generate($contenido);
        $base64 = base64_encode($result_qr_content_in_png);
        $itemqr[0]->base64 = $base64;*/
        return $itemqr;
    }

    public function itemQR64($id)
    {
        $itemqr = ItemQR::where( 'id_certificado', '=', $id )->get ();
        $base64 = base64_encode(file_get_contents(public_path().'/default/qr.png'));
        $size = getimagesizefromstring(file_get_contents(public_path().'/default/qr.png'));
        $itemqr[0]->base64 = $base64;
        $itemqr[0]->anchoImg = $size[0];
        $itemqr[0]->altoImg = $size[1];
        return $itemqr;
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
        DB::table('itemqr')->where('id_certificado', $input[0]['id_certificado'])->delete();
        foreach ($input as $key => $value) {
            ItemQR::create($value);
        }
        return response()->json([
            'pru'=>$input,
            'res'=>true,
            'message'=>'ItemQR creado correctamente'
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
        $fileName = 'qr.png';

        $filePath = public_path().'/default/'.$fileName;
        return response()->file($filePath);
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
