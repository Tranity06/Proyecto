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
            // Redirigir al login si no hay admin logueado
        $admin = $request->session()->get('nombre');
        if ($admin == null){
            return redirect('/admin');
        }
            //Extraer los datos del administrador logueado
        $datos = Administrador::where('name', $admin)->first();
            //Es necesrio pasar el parámetro 'admin' con el nombre del admin
        return view('admin.administrador.perfil', compact('datos', 'admin'));          
    }

    /**
     * AJAX - Comprueba que el dato del administrador enviado no existe en la base de datos
     * @return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    public function comprobarDatos(Request $request){
            // Redirigir al login si no hay admin logueado
        $admin = $request->session()->get('nombre');
        if ($admin == null){
            return redirect('/admin');
        }
            // Redirigir si la petidicón es de tipo GET
        if ( $request->isMethod('get')){
            return redirect('admin/settings');
        }
            //Comprobar si el dato recibido corresponde a un email o a un nombre
            //Comprobar que no existe en la bbdd
        $recibido = $request['valor'];
        if ( strpos($recibido, '@') == null ){
            $sol = $this->comprobarNombre($recibido);
            return response('nombre', $sol);
        }
        $sol = $this->comprobarEmail( $recibido );
        return response('email', $sol);          
    }

    /**
     * Guarda los datos del administrador que se han modificado.
     * Comprueba si son datos propios del usuario logueado o de otro usuario.
     * Sólo permite modificar datos agenos al super usuario.
     */
    public function modificarAdmin(Request $request){
            // Redirigir al login si no hay admin logueado
        $admin = $request->session()->get('nombre');
        if ($admin == null){
            return redirect('/admin');
        }
            // Redirigir si la petidicón es de tipo GET
        if ( $request->isMethod('get')){
            return redirect('admin/settings');
        }
        
        //Si se modifica datos de otro administrador distindo al logueado
        if ( isset($request['id']) ){
            //Solo el superadmin puede hacerlo
            if ( Administrador::select('id')->where('name', $admin)->first() !== 1 ){
                return redirect('admin/administradores');
            }
            $datos = Administrador::find($request['id']);
        } else {
            // Si es el administrador logueado
            $datos = Administrador::where('name', $admin)->first();
        }        
            //Quitar los espacios en blanco que vengan en los datos
        $nombre = trim($request['nombre']);
        $email = trim($request['email']);
        $pw = trim($request['pw']);

        //Compruebar que los datos no existen en la bbdd
        if ( $this->comprobarNombre($nombre) === 201 && $this->comprobarEmail($email) === 201 ){
            if ( strlen($nombre) > 0 ){
                $datos->name = $nombre;
                $admin = $nombre;
                //Modificar la sesión si se modifica el admin logueado
                if ( !isset($request['id']) ){
                    $request->session()->put('nombre', $nombre);
                }
            } 
            if ( strlen($email) > 0 ){
                $datos->email = $email;
            }
            if ( strlen($pw) > 0 ){
                $datos->password = bcrypt($pw);
            }
            $datos->save();
            $correcto = 'S';

                //Volver a la lista de administradores.
            if ( isset($request['id']) ){
                return redirect('admin/administradores') ;
            }
            //Volver al perfil si se modifican datos de perfil.
            return view('admin.administrador.perfil', compact('datos', 'admin', 'correcto'));
        }
        $tipoError = 'Error al intentar modificar los datos.';
        $mensajeError = 'Es posible que los datos introducidos sean erróneos o ya existan en la base de datos.';
        return view('admin.administrador.error', compact('admin', 'tipoError', 'mensajeError'));        
    }
    
    /**
     * Si el usuario logueado es el usuario principal devuelve la vista del formulario para crear 
     * un nuevo administrador.
     * Si no lo es devuelve un mensaje de error.
     */
    public function crearGet (Request $request){
        // Redirigir al login si no hay admin logueado
        $admin = $request->session()->get('nombre');
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

        $administrador = Administrador::where('name', $admin)->first();
        if ( $administrador->id == 1 ){
            $nuevo_admin = Administrador::create([
                'name' => $request['nombre'],
                'email' => $request['email'],
                'password' => bcrypt($request['pw'])
            ]);

            return view('admin.administrador.crearPost', compact('admin','nuevo_admin'));
        }

        //Si no es el administrador principal devuelve un mensaje de error.
        $tipoError = "Permiso denegado";
        $mensajeError = "Sólo el adminstrador principal puede crear nuevas cuentas de usuario.";
        return view('admin.administrador.error', compact('admin', 'tipoError', 'mensajeError'));
    }
    
    /**
     * Muestra la lista de los administradores registrados en la base de datos.
     */
    public function mostrar(Request $request){
        // Redirigir al login si no hay admin logueado
        $admin = $request->session()->get('nombre');
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
        // Redirigir al login si no hay admin logueado
        $admin = $request->session()->get('nombre');
        if ($admin == null){
            return redirect('/admin');
        }
        
        //Redirigir si la petición es get
        if ( $request->isMethod('get')){
            return redirect('admin');
        }
        
        $supAdmin = Administrador::where('name', $admin)->first(); //Recoger los datos del administrador logueado

        
        if ( $supAdmin->id == 1 ){
            $administrador = Administrador::find($request['id']);
            $administrador->delete();
            return response('Borrado', 204);
        }
        return response('Permiso denegado', 403);;        
    }
    
    /**
     * Comprueba que el nombre del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    protected static function comprobarNombre( $nombre ){
        $administrador = Administrador::where('name', $nombre)->first();
        if ( $administrador == null ){
            return 201;
        }
        return 204;
    }

    /**
     * Comprueba que el email del administrador enviado no existe en la base de datos
     * return 'valido' -> el usuario no existe
     *        'existe' ->el usuario existe
     */
    protected static function comprobarEmail( $email ){
        $administrador = Administrador::where('email', $email)->first();
        if ( $administrador == null ){
            return 201;
        }
        return 204;
    }
}
