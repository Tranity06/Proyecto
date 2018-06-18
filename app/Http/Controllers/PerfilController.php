<?php
/**
 * Created by PhpStorm.
 * User: Emanuel
 * Date: 5/6/18
 * Time: 21:32
 */

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Sesion;
use App\Models\Pelicula;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Image;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PerfilController extends Controller {

    public function cambiarEmail(Request $request){
        $user = User::find($this->getUser()->id);

        $user->email = $request->email;

        $user->saveOrFail();

        return response()->json('Success',201);
    }

    public function cambiarTelefono(Request $request){
        $user = User::find($this->getUser()->id);

        $user->telefono = $request->telefono;

        $user->saveOrFail();

        return response()->json('Success',201);
    }

    public function cambiarAvatar(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()],400);
        } else {
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->resize(300, 300)->save( public_path('/uploads/avatars/' . $fileName));

            $user = User::find($this->getUser()->id);
            $user->avatar = $fileName;
            $user->saveOrFail();

            return response()->json(['success'=>true,'avatar_name'=>$fileName],200);
        }
    }

    public function cambiarClave(Request $request){
        $data = $request->only('password','password_confirmation','paso');
        $rules = [
            'paso' => 'required',
            'password' => 'required|min:6|confirmed'
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => 'Los datos introducidos no son correctos.'],400);
        }

        if ($request->paso === 1){
            $credentials['email']=User::find($this->getUser()->id)->email;
            $credentials['password']=$request->password;

            if ( ! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false], 401);
            }
            return response()->json(true,200);
        }

        if ($request->paso === 2){
            $credentials['email']=User::find($this->getUser()->id)->email;
            $credentials['password']=$request->password;

            $user = User::find($this->getUser()->id);
            $user->password = bcrypt($request->password);
            $user->saveOrFail();
            if ( ! $token = JWTAuth::attempt($credentials)) {
                return response()->json(false, 401);
            }
            return response()->json(['token' => $token],200);
        }
    }

    public function eliminarCuenta(Request $request){
        $data = $request->only('password');
        $rules = [
            'password' => 'required|min:6|max:20'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => 'Los datos introducidos no son correctos.'],400);
        }else{

            $credentials['email']=User::find($this->getUser()->id)->email;
            $credentials['password']=$request->password;

            if ( ! $token = JWTAuth::attempt($credentials)) {
                return response()->json(false, 401);
            }
            return response()->json(true,200);
        }

    }

    public function getUser(){
        $user = JWTAuth::toUser(JWTAuth::getToken());
        if ( $user == null ) {
            return response()->json('Permiso denegado', 403);
        }

        return $user;
    }

    public function allTicketsFromUser(){
        try{
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (JWTException $e){
            return response()->json('Permiso denegado.', 403);
        } 

        $tickets = $user->facturas();

        if ( sizeof($tickets)<=0 ) {
            dd('null');
        }
        $userTickets = [];
        foreach ($tickets as $ticket ){
            $datos['fecha_factura'] = $ticket->fecha;
            $butacas = $ticket->butacas_reservadas()->get();
            $sesion = Sesion::find($butacas[0]['sesion_id']);
            $datos['nombre_pelicula'] = Pelicula::find($sesion->pelicula_id)->titulo;
            $datos['fecha_pelicula'] = $sesion->fecha;
            $datos['hora'] = $sesion->hora;
            $datos['sala_id'] = $sesion->sala_id;
            for ($i=0 ; $i<sizeof($butacas) ; $i++ ){
                $datos['butacas'][$i] = $butacas[$i]['id'];
            }

            $productos = $ticket->lineas_venta();
            $datos['items_restaurante'] = [];
            $datos['total'] = 0;
            foreach ( $productos as $producto ){
                $datosProducto['nombre'] = Producto::find($producto->producto_id)->nombre;
                $datosProducto['cantidad'] = $producto->cantidad;
                $datosProducto['precio'] = Producto::find($producto->producto_id)->precio;
                array_push($datos['items_restaurante'], $datosProducto);
                $datos['total']+=((int)($datosProducto['cantidad'])*(int)($datosProducto['precio']));
            }

        }
        return response()->json($datos, 200);
    }
}