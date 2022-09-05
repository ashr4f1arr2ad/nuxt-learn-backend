<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
    */
    public function __construct()
    {
//        $this->middleware('auth:api', [
//            'except' => ['login']
//        ]);
        $this->middleware('auth:api', [
            'except' => ['register', 'store']
        ]);
    }

    public function register(Request $request) {
        $register = new Register;
        $register->email = $request->input('email');
        $register->password = Hash::make($request->input('password'));
        $register->save();

        return response()->json([
            'message' => 'Created Successfully',
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        return $this->respondWithToken($this->guard('api')->refresh());
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function store(Request $request) {
        // $all = User::all();
        // var_dump($all);
        // echo "fdsfds";
        $credentials = $request->only('email', 'password');
        // print_r($credentials);
        $token = $this->guard()->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 401,
                'error' => 'Incorrect email or password',
                'danger' => 'Not Login'
            ]);
        } else {
            return $this->respondWithToken($token);
        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function me()
    {
        return response()->json($this->guard('api')->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            '_token' => csrf_token(),
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60 * 60,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
    */
    public function guard()
    {
        return Auth::guard();
    }
}
