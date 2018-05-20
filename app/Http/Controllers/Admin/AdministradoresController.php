<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;

class AdministradoresController extends Controller
{
    /**
     * Muestra la información del usuario logueado
     */
    public function mostrarDetalleCuenta(){
            // Redirigir al login si no hay admin logueado
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user()->name;
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
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
            // Redirigir si la petidicón es de tipo GET
        if ( $request->isMethod('get')){
            return redirect('admin/settings');
        }
            //Comprobar si el dato recibido corresponde a un email o a un nombre
            //Comprobar que no existe en la bbdd
        $recibido = $request->valor;
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
        //Comprobar el acceso
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        if ( $request->isMethod('get')){
            return redirect('admin/settings');
        }
        
        //Comprobar los permisos
        $admin = Auth::guard('admin')->user();
        if ( $admin->id !== 1 ){
            $tipoError = "Permiso denegado.";
            $mensajeError = "No tienes permisos para realizar esta acción.";
            return view('admin.administrador.error')
                        ->with([
                            'admin' => $admin->nombre,
                            'tipoError' => $tipoError,
                            'mensajeError' => $mensajeError
                        ]);
        }
        $datos = Administrador::find($request->id);
        

        //Validar los datos
        $credentials = $request->only('name', 'email', 'password', 'id');
        $rules = [
            'name' => 'nullable|string|max:20|unique:administradores',
            'email' => 'nullable|string|email|max:255|unique:administradores',
            'password' => 'nullable|string|regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{6,12}$/',
        ];

        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return Redirect::to('admin/administradores')->withErrors($validator);
        }


        //Realizarlos cambios
        $nombre = trim($request->name);
        $email = trim($request->email);
        $pw = trim($request->password);

        if ( $this->comprobarNombre($nombre) === 201 && $this->comprobarEmail($email) === 201 ){
            if ( strlen($nombre) > 0 ){
                $datos->name = $nombre;
            } 
            if ( strlen($email) > 0 ){
                $datos->email = $email;
            }
            if ( strlen($pw) > 0 ){
                $datos->password = bcrypt($pw);
            }
            $datos->save();
            $correcto = 'S';
            return view('admin.administrador.mostrar')
                        ->with(['admin' => $admin->name,
                        'administradores'=> Administrador::all(),
                        'sumerAdmin' => 'sa'
                        ]) ;
           
        }
        $tipoError = 'Error al intentar modificar los datos.';
        $mensajeError = 'Es posible que los datos introducidos sean erróneos o ya existan en la base de datos.';
        return view('admin.administrador.error', compact('admin', 'tipoError', 'mensajeError'));        
    }



    ///////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    /**
     * Guarda los datos del administrador que se han modificado.
     * Comprueba si son datos propios del usuario logueado o de otro usuario.
     * Sólo permite modificar datos agenos al super usuario.
     */
    public function modificarPerfil(Request $request){
        //Comprobar el acceso
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        if ( $request->isMethod('get')){
            return redirect('admin/settings');
        }
        
        //Comprobar los permisos
        $admin = Auth::guard('admin')->user();        

        //Validar los datos
        $credentials = $request->only('name', 'email', 'password', 'id');
        $rules = [
            'name' => 'nullable|string|max:20|unique:administradores',
            'email' => 'nullable|string|email|max:255|unique:administradores',
            'password' => 'nullable|string|regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{6,12}$/',
        ];

        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return Redirect::to('admin/settings')->withErrors($validator);
        }


        //Realizarlos cambios
        $nombre = trim($request->name);
        $email = trim($request->email);
        $pw = trim($request->password);

        if ( $this->comprobarNombre($nombre) === 201 && $this->comprobarEmail($email) === 201 ){
            if ( strlen($nombre) > 0 ){
                $admin->name = $nombre;
            } 
            if ( strlen($email) > 0 ){
                $admin->email = $email;
            }
            if ( strlen($pw) > 0 ){
                $admin->password = bcrypt($pw);
            }
            $admin->save();
            $correcto = 'S';

            //Volver al perfil.
            return view('admin.administrador.perfil')
                    ->with([
                        'datos' => $admin,
                        'admin' => $admin->nombre,
                        'correcto' => $correcto
                    ]);
        }
        $tipoError = 'Error al intentar modificar los datos.';
        $mensajeError = 'Es posible que los datos introducidos sean erróneos o ya existan en la base de datos.';
        return view('admin.administrador.error', compact('admin', 'tipoError', 'mensajeError'));        
    }

    //////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
    
    /**
     * Si el usuario logueado es el usuario principal devuelve la vista del formulario para crear 
     * un nuevo administrador.
     * Si no lo es devuelve un mensaje de error.
     */
    public function crearGet (){
        //Comprobar acceso
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user();

        //Comprobar permisos
        if ( $admin->id == 1 ){
            return view('admin.administrador.crearGet')
                    ->with(['admin' => $admin->name ]);
        }
        return view('admin.administrador.error')
                    ->with([
                        'admin' => $admin->name,
                        'tipoError' => "Permiso denegado",
                        'mensajeError' => "Sólo el adminstrador principal puede crear nuevas cuentas de usuario.",
                    ]);
    }
    
    /**
     * Guarda en la base de datos un nuevo administrador si los datos son correctos.
     */
    public function crearPost(Request $request){
        //Comprobar acceso
        if (!Auth::guard('admin')->check() || Administrador::where('name', $request->name)->first()!==null ){
            return redirect('/admin');
        }

        //Comprobar permisos
        $admin = Auth::guard('admin')->user();
        if ( $admin->id == 1 ){
            //Validar los datos
            $credentials = $request->only('name', 'email', 'password', 'id');
            $rules = [
                'name' => 'required|string|max:20|unique:administradores',
                'email' => 'required|string|email|max:255|unique:administradores',
                'password' => 'required|string|regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{6,12}$/',
            ];

            $validator = Validator::make($credentials, $rules);
            if ($validator->fails()) {
                return Redirect::to('admin/crearadministrador')->withErrors($validator);
            }

            $nuevo_admin = Administrador::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return view('admin.administrador.crearPost')
                        ->with([
                            'admin' => $admin->name,
                            'nuevo_admin' => $nuevo_admin
                        ]);
        }

        //Si no es el administrador principal devuelve un mensaje de error.
        $tipoError = "Permiso denegado";
        $mensajeError = "Sólo el adminstrador principal puede crear nuevas cuentas de usuario.";
        return view('admin.administrador.error')
                    ->with([
                        'admin' => $admin->name,
                        'tipoError' => "Permiso denegado",
                        'mensajeError' => "Sólo el adminstrador principal puede crear nuevas cuentas de usuario.",
                    ]);
    }
    
    /**
     * Muestra la lista de los administradores registrados en la base de datos.
     */
    public function mostrar(){
            // Redirigir al login si no hay admin logueado
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user();
        $administradores = Administrador::all();
        
        //Si el administrador logueado es el administrador principal envía datos para la vista extra que
        //los administradores normales no pueden ver
        if ( $admin->id == 1 ){
            return view('admin.administrador.mostrar')
                    ->with([
                        'admin' => $admin->name,
                        'administradores' => $administradores,
                        'sumerAdmin' => 'sa'
                    ]);
        }

        //Vista para los administradores normales
        return view('admin.administrador.mostrar' )
                    ->with([
                        'admin' => $admin->name,
                        'administradores' => $administradores,
                    ]);
    }

    /**
     * Borra el usuario seleccionado por el usuario.
     */
    public function borrar(Request $request){
            // Redirigir al login si no hay admin logueado
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user();
        
        //Redirigir si la petición es get
        if ( $request->isMethod('get')){
            return redirect('admin');
        }
        
        if ( $admin->id == 1 ){
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
