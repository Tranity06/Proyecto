<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administrador;

class AdministradoresController extends Controller
{
    /**
     * Muestra la información del usuario logueado
     */
    public function mostrarDetalleCuenta(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion
        
        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }
        
        //Si hay un usuario logueado muestra sus datos
        $datos = Administrador::where('name', $admin)->first(); //Extraer los datos del usuario
        //Es necesrio pasar el parámetro 'admin' con el nombre del admin
        return view('admin.administrador.perfil', compact('datos', 'admin'));          
    }

    /**
     * Comprueba que el dato del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    public function comprobarDatos(Request $request){
        $recibido = $request['valor'];
        
        if ( strpos($recibido, '@') == null ){
            $sol = $this->comprobarNombre($recibido);
            return $sol;
        } else {
            $sol = $this->comprobarEmail( $recibido );
            return $sol;            
        }
    }

    public function modificarAdmin(Request $request){
        $admin = $request->session()->get('nombre');
        $datos = Administrador::where('name', $admin)->first();
        $nombre = trim($request['nombre']);
        $email = trim($request['email']);
        $pw = trim($request['pw']);
        if ( $this->comprobarNombre($nombre) === "valido" && $this->comprobarEmail($email) === "valido" ){
            if ( strlen($nombre) > 0 ){
                $datos->name = $nombre;
                $request->session()->put('nombre', $nombre);
            } 
            if ( strlen($email) > 0 ){
                $datos->email = $email;
            }
            if ( strlen($pw) > 0 ){
                $datos->password = bcrypt($pw);
            }
            $datos->save();
            $admin = $nombre;
            $correcto = 'S';
            return view('admin.administrador.perfil', compact('datos', 'admin', 'correcto'));
        }
        dd("Mal");
    }

    /**
     * Comprueba que el nombre del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    private function comprobarNombre( $nombre ){
        $administrador = Administrador::where('name', $nombre)->first();
        if ( $administrador == null ){
            return "valido";
        }
        return "existe";
    }

    /**
     * Comprueba que el email del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    static function comprobarEmail( $email ){
        $administrador = Administrador::where('email', $email)->first();
        if ( $administrador == null ){
            return "valido";
        }
        return "existe";
    }
}
