<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Usuario;
use Auth;

class UsuarioController extends Controller
{
    public function store(Request $request){
        try{
            if(!$request->has('username') || !$request->has('password') || !$request->has('nombres') || !$request->has('correo')){
                throw new \Exception('Campos mandatorios');
            }

            $usuario = new Usuario();
            $usuario->username = $request->get('username');
    		$usuario->password = $request->get('password');
    		$usuario->nombres = $request->get('nombres');
    		$usuario->correo = $request->get('correo');

    		$usuario->save();

    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);

        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }

    }
    
    public function login(Request $request){

      try{

      $nombre = $request->get('username');
      $clave = $request->get('password');
      
      $nombreUsu = Usuario::where('username', $nombre)->get();
      $claveUsu = Usuario::where('password', "$clave")->get();
      
      foreach($nombreUsu as $nombreUsu){
          $dato_nom = $nombreUsu->username;
      }
      
      foreach($claveUsu as $claveUsu){
          $dato_pass = $claveUsu->password;
      }
      
          if($dato_nom == $nombre && $dato_pass == $clave){
              return response()->json(['type' => 'success', 'message' => $nombre.', Usuario valido'], 200);
          }

          throw new \Exception('Usuario no encontrado');

      }catch(\Exception $exception){
          return response()->json(['type' => 'error', "message" => 'Usuario o Contraseña incorrecta'], 500);
      }

  }
  
  public function index(){
        $user = Usuario::all();
        return $user;
    }
    
}
