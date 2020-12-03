<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImgS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImgSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImgS::orderBy('id', 'desc')->get();
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
        if($request->has('nombre'))
            $input['nombre']=$this->cargarArchivo($request->nombre);

        ImgS::create($input);
        $id = DB::getPdo()->lastInsertId();
        return response()->json([
            'id'=>$id,
            'res'=>true,
            'message'=>'ImgS registrado correctamente'
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
        $membrete = ImgS::select('nombre')->where( 'id', '=', $id )->get ();
        $fileName = $membrete->first()->nombre;

        $filePath = public_path().'/imgs/'.$fileName;
        return response()->file($filePath);
    }

    private function cargarArchivo($file)
    {
        $nombreArchivo = time().".".$file->getClientOriginalExtension();
        $file->move(public_path('imgs'), $nombreArchivo);
        return $nombreArchivo;
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
        $membrete = ImgS::select('nombre')->where( 'id', '=', $id )->get ();
        $fileName = $membrete->first()->nombre;
        $filePath = public_path().'/imgs/'.$fileName;
        if(File::exists($filePath)) {
            File::delete($filePath);
        }

        ImgS::destroy($id);
        return response()->json([
            'res'=>true,
            'message'=>'ImgS eliminado correctamente'
        ], 200);
    }
}
