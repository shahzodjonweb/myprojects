<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use Validator;
use JWTAuth;
use Config;
class DriverAuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        Config::set('jwt.user', Driver::class);
    Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Driver::class,
        ]]);
        $this->middleware('auth:api', ['except' => ['login', 'register','change_password']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       
        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
       $user= JWTAuth::user();
       $user -> api_token = $token;
       $user ->update();
        return $this->createNewToken($token);
    }
    public function change_password(Request $request){

     
    	$validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ]);
       
       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       // dd($validator->validated());
        $array=$validator->validated();
        array_pop($array);
        if (! $token = JWTAuth::attempt($array)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
       $user= JWTAuth::user();
       $user -> password = bcrypt($request['new_password']);
       $user ->update();

       $token = JWTAuth::fromUser($user);
       $user2= JWTAuth::user();
       $user2 -> api_token = $token;
       $user2 ->update();

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function register(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'firstname' => 'required|string|between:2,100',
    //         'lastname' => 'required|string|between:2,100',
    //         'phone' => 'required|string|max:15|unique:users',
    //         'email' => 'string|email|max:100|unique:users',
    //         'password' => 'required|string|min:5',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }
    
    //     $user=new User();
    //     $user->firstname = $request["firstname"];
    //     $user->lastname = $request["lastname"];
    //     $user->phone = $request["phone"];
    //     $user->password = bcrypt($request["password"]);
    //     $user->lastlogin =date('Y-m-d H:i:s');
    //     $user->save();

    //     return response()->json([
    //         'message' => 'User successfully registered',
    //         'user' => $user
    //     ], 201);
    // }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        JWTAuth::logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(JWTAuth::refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(JWTAuth::user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => JWTAuth::user()
        ]);
    }
}
