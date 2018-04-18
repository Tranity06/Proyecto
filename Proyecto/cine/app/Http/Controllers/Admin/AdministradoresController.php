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
     * AJAX - Comprueba que el dato del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    public function comprobarDatos(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion
        
        // Si no hay ningún usuario logueado o si no recibe un token del formulario regirige al login
        if ( $admin == null || !isset($request['token']) ){
            return redirect('/admin');
        }

        $recibido = $request['valor'];
        //Comprobar si el dato recibido corresponde a un email o no
        if ( strpos($recibido, '@') == null ){
            $sol = $this->comprobarNombre($recibido);
            return $sol;
        }
        $sol = $this->comprobarEmail( $recibido );
        return $sol;            
    }

    /**
     * Guarda los datos que el usuario ha modificado en un formulario sobre el
     * administrador logueado.
     */
    public function modificarAdmin(Request $request){
        $admin = $request->session()->get('nombre');

        // Si no hay ningún usuario logueado regirige al login
        if ( $admin == null || !isset($request['token'])  ){
            return redirect('/admin');
        }

        //Extrae todos los datos del usuario logueado.
        $datos = Administrador::where('name', $admin)->first();

        //Quitar los posibles espacios en blanco que vengan en los datos
        $nombre = trim($request['nombre']);
        $email = trim($request['email']);
        $pw = trim($request['pw']);

        //Comprueba que no se repiten los datos y si son válidos los actualiza en los datos del usuario
        if ( $this->comprobarNombre($nombre) === "valido" && $this->comprobarEmail($email) === "valido" ){
            if ( strlen($nombre) > 0 ){
                $datos->name = $nombre;
                $admin = $nombre;
                $request->session()->put('nombre', $nombre);
            } 
            if ( strlen($email) > 0 ){
                $datos->email = $email;
            }
            if ( strlen($pw) > 0 ){
                $datos->password = bcrypt($pw);
            }
            $datos->save();
            $correcto = 'S';
            
        }
        return view('admin.administrador.perfil', compact('datos', 'admin', 'correcto'));
    }

    /**
     * Si el usuario logueado es el usuario principal devuelve la vista del formulario para crear 
     * un nuevo administrador.
     * Si no lo es devuelve un mensaje de error.
     */
    public function crearGet (Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion
        
        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }

        //Si es el administrador principal devuelve la vista del formulario.
        $administrador = Administrador::where('name', $admin)->first();
        if ( $administrador->id == 1 ){
            return view('admin.administrador.crearGet', compact('admin'));
        }

        //Si no es el administrador principal devuelve un mensaje de error.
        $tipoError = "Permiso denegado";
        $mensajeError = "Sólo el adminstrador principal puede crear nuevas cuentas de usuario.";
        return view('admin.administrador.error', compact('admin', 'tipoError', 'mensajeError'));
    }

    /**
     * Guarda en la base de datos un nuevo administrador si los datos son correctos.
     */
    public function crearPost(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion

        // Si no hay ningún usuario logueado o el nombre ya está registrado regirige al login.
        //Esto evita errores de duplicados al actualizar la página después de crear un usuario.
        if ($admin == null || Administrador::where('name', $request['nombre'])->first()!==null ){
            return redirect('/admin');
        }

        $nuevo_admin = Administrador::create([
            'name' => $request['nombre'],
            'email' => $request['email'],
            'password' => bcrypt($request['pw'])
        ]);

        return view('admin.administrador.crearPost', compact('admin','nuevo_admin'));
    }

    /**
     * Muestra la lista de los administradores registrados en la base de datos.
     */
    public function mostrar(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion
        
        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }

        $administradores = Administrador::all();
        $supAdmin = Administrador::where('name', $admin)->first(); //Recoger los datos del administrador logueado

        //Si el administrador logueado es el administrador principal envía datos para la vista extra que
        //los administradores normales no pueden ver
        if ( $supAdmin->id == 1 ){
            return view('admin.administrador.mostrar', compact('admin','administradores'))
                    ->with('sumerAdmin', 'sa');
        }

        //Vista para los administradores normales
        return view('admin.administrador.mostrar', compact('admin','administradores'));
    }

    /**
     * Borra el usuario seleccionado por el usuario.
     */
    public function borrar(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion
        
        $administrador = Administrador::find($request['id']);

        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null || !isset($request['token']) || !$administrador ){ //Añadir posible duplicado de borrado
            return redirect('/admin');
        }

        $administrador->delete();
        return "Borrado";
    }

    /**
     * Comprueba que el nombre del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    private static function comprobarNombre( $nombre ){
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
    private static function comprobarEmail( $email ){
        $administrador = Administrador::where('email', $email)->first();
        if ( $administrador == null ){
            return "valido";
        }
        return "existe";
    }
}
