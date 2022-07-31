<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
//use App\Events\EventUserLog;

class AuthController extends Controller
{
    private $event;

    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login']]);
        //$this->event = collect(['host' => url()->current(), 'active'=> true, 'remote_ip' => \Request::getClientIp(), 'source' => 'api']);
    }

    public function login(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'email'     => 'required|exists:users,email',
            'password'  => 'required',
            'latitude'  => 'required',
            'longitude' => 'required',
            'imei'      => 'required',//|exists:territorial.imeis,imei',
        ],[
            'email.required'        => 'El correo electrónico es obligatorio',
            'email.exists'          => 'El correo electrónico no se encontró dado de alta',
            'password.required'     => 'La password es obligatorio',
            'latitude.required'     => 'La latitud es obligatorio',
            'longitude.required'    => 'La longitud es obligatorio',
            'imei.required_without' => 'El IMEI es obligatorio',
            'imei.exists'           => 'El IMEI no está registrado, acuda con su coordinador.'
        ]);


        if ($validator->fails()) {
            /*$this->event->put('request',$request->except(['password']));
            $this->event->put('validation',$validator->errors());
            $this->event->put('type', 'login');
            $this->event->put('attemp', 'failed');
            event(new EventUserLog($this->event));*/
            return response()->json([
                'response' => [
                    'code'       => 1,
                    'validation' => $validator->errors()
                ],
                'data'       => [],

            ], 400);
        }

        $credentials = $request->only(['email', 'password']);
        
        $claims = [
            'imei'    => $request->imei,
        ];

        $token = auth('api')->claims($claims)->attempt($credentials);

        if (!$token) {
            /*$this->event->put('imei',$request->imei);
            $this->event->put('latitude',$request->latitude);
            $this->event->put('longitude',$request->longitude);
            $this->event->put('sessionID', [\Session::getId()]);
            $this->event->put('email', $request->email);
            $this->event->put('type', 'login');
            $this->event->put('attemp', 'failed');
            $this->event->put('cause','Sin autorización');
            event(new EventUserLog($this->event));*/

            return response()->json([
                'response' => [
                    'code'       => 1,
                    'msg'        => 'La contraseña es incorrecta',
                    'validation' => []
                ],
                'data'     => []
            ], 401);
        }

        return $this->respondWithToken($request,$token);
    }

    /**
     * \brief Método me de la clase AuthController.
     * \param void
     * \return data json.
     * \note Se define el proceso para obtener los datos del
     *       usuario autentificado.
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * \brief Método payload de la clase AuthController.
     * \param void
     * \return data json.
     * \note Se define el proceso para obtener los datos del
     *       usuario autentificado y cargarlos a los servicios
     *       necesarios.
     */
    public function payload()
    {
        return response()->json(auth('api')->payload());
    }

    /**
     * \brief Método logout de la clase AuthController.
     * \param void
     * \return data json.
     * \note Se define el proceso para cerrar la sesión del
     *       usuario logueado.
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Ha salido exitósamente']);
    }

    /**
     * \brief Método refresh de la clase AuthController.
     * \param void
     * \return data json.
     * \note Se define el proceso para recargar la sesión del
     *       usuario logueado.
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * \brief Método respondWithToken de la clase AuthController.
     * \param $request - collect - Colección de datos.
     * \param $token - String - Token de acceso.
     * \return data json.
     * \note Se define el proceso para retornar los datos del
     *       usuario autentificado con el token JWT de acceso.
     */
    protected function respondWithToken($request, $token)
    {
        /*$this->event->put('imei',$request->imei);
        $this->event->put('latitude',$request->latitude);
        $this->event->put('longitude',$request->longitude);
        $this->event->put('sessionID', [session()->getId()]);
        $this->event->put('user_id', auth('api')->user()->id);
        $this->event->put('type', 'login');
        $this->event->put('attemp', 'success');
        event(new EventUserLog($this->event));*/

        return response()->json([
            'response' => [
                'code' => 0,
                'msg'  => 'Ok'
            ],
            'data'  => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL(),
                'user'         => [
                    'name'    => auth('api')->user()->name,
                    'paterno' => auth('api')->user()->paterno,
                    'materno' => auth('api')->user()->materno,
                    'email'   => auth('api')->user()->email,
                    'user_id' => auth('api')->user()->id,
                ],
            ]
        ], 200);
    }

}