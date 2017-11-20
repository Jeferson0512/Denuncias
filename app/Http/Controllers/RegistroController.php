<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Registro;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RegistroController extends Controller
{
    
        public function store(Request $request)
    {
        try
        {
            if(!$request->has('titulo') || !$request->has('descripcion'))
            {
                throw new \Exception('Se esperaba campos mandatorios');
            }
            
            $registro = new Registro();
            $registro->titulo = $request->get('titulo');
    		$registro->descripcion = $request->get('descripcion');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())
    		{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$registro->imagen = $filename;
    		}
    		
    		$registro->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function index(){
        $registro_denuncia = Registro::where('estado',1)->orderBy("titulo")->get();
        //$registro_denuncia = Registro::all();
        return $registro_denuncia;
    }
    
    public function destroy($id){
        try
        {
            $registro = Registro::find($id);
            
            if($registro == null)
                throw new \Exception('Registro no encontrado');
    		
    		if(Storage::disk('images')->exists($registro->imagen))
    		    Storage::disk('images')->delete($registro->imagen);
    		
    		$registro->delete();
    		
            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function show($id){
        try
        {
            $registro = Registro::find($id);
            
            if($registro == null)
                throw new \Exception('Registro no encontrado');
    		
            return $registro;
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


}
