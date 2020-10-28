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
