<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;

class ApiController extends Controller
{
    
    public function store(Request $request){
        try{
            if(!$request->has('username') || !$request->has('password') || !$request->has('nombres') || !$request->has('correo') || !$request->has('estado')){
                throw new \Exception('Campos mandatorios');
            }

            $usuario = new Usuario();
            $usuario->username = $request->get('username');
    		$usuario->password = $request->get('password');
    		$usuario->nombres = $request->get('nombres');
    		$usuario->correo = $request->get('correo');
    		$usuario->estado = $request->get('estado');

    		$usuario->save();

    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);

        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }

    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if (Auth::once($credentials)) 
        {
         $user = Auth::user();
         
         return $user;
        }
        return response()->json(['error' => 'Usuario y/o clave inválido'], 402); 
    }
    
    public function index(){
        $user = Usuario::all();
        return $user;
    }

}
