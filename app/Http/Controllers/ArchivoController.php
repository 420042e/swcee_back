<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_evento = $request->input('id_evento');
        $q = $request->input('search');
        $user = Archivo::select('archivos.id', 'archivos.nombre', 'archivos.id_evento')
                            ->where( 'archivos.nombre', 'LIKE', '%' . $q . '%' )
                            ->where( 'archivos.id_evento', '=', $id_evento )
                            ->orderBy('archivos.id', 'desc')
                            ->paginate (10)
                            ->setPath ( '' );
        return $user;
    }

    public function descargarArchi($nombre)
    {
        $file = public_path(). "/archivos/".$nombre;
        $headers = array(
              'Content-Type: image/jpg',
            );
        //return Response::download($file, 'filename.jpg', $headers);
        //return Storage::download($file, 'filename.jpg', $headers);
        //return response()->download($path, $file, $header);

        //return Storage::download(public_path().'/archivos/'.$nombre);
        //return Storage::disk('public')->download('/archivos/'.$nombre, $nombre);
        //return Storage::download(public_path().'/archivos/'.$nombre, "hola.jpg", array('Content-type: image/jpeg'));
        //return response()->download(storage_path("archivos\\public\\{$nombre}"));

        return response()->download(public_path(). '/archivos/'.$nombre);
        //return Storage::download(public_path().'/archivos/'.$nombre);
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
        {
            foreach ($input['nombre'] as $datavals) {
                $dato['id_evento'] = $input['id_evento'];
                $dato['nombre'] = $this->cargarArchivo($datavals);
                Archivo::create($dato);
            }
        }

        return response()->json([
            'res'=>true,
            'message'=>'Archivos de evento registrados correctamente'
        ], 200);*/

        
        $input = $request->all();
        if($request->has('nombre'))
        {
            $input['nombre']=$this->cargarArchivo($request->nombre);
            $input['id_evento']=$request->id_evento;
            Archivo::create($input);
            $id = DB::getPdo()->lastInsertId();
            $archivo = Archivo::select('id', 'nombre')
                ->where( 'id', '=', $id )->get ();
            return response()->json([
                'id'=>$id,
                'archivo'=>$archivo,
                'res'=>true,
                'message'=>'Archivo de evento registrado correctamente'
            ], 200);
        }
        
            
        /*$input = $request->all();
        if($request->has('nombre'))
        {
            Archivo::create($input);
            $id = DB::getPdo()->lastInsertId();
            return response()->json([
                'id'=>$id,
                'res'=>true,
                'message'=>'Archivo de evento registrado correctamente'
            ], 200);
        }*/
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

    private function cargarArchivo($file)
    {
        $nombreArchivo = time().".".$file->getClientOriginalExtension();
        $file->move(public_path('archivos'), $nombreArchivo);
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
        $membrete = Archivo::select('nombre')->where( 'id', '=', $id )->get ();
        $fileName = $membrete->first()->nombre;
        $filePath = public_path().'/archivos/'.$fileName;
        if(File::exists($filePath)) {
            File::delete($filePath);
        }

        Archivo::destroy($id);
        return response()->json([
            'res'=>true,
            'message'=>'Archivo de evento eliminado correctamente'
        ], 200);
    }
}
