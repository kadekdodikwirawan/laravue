<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    /**
     * Register
     */
    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $message = 'User register successfully';
            return $this->successResponse($user, $message);
        } catch (\Illuminate\Database\QueryException $ex) {
            $message = $ex->getMessage();
            return $this->errorResponse($message, 422);
        }
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
           return $this->errorResponse('The given data was invalid.', 422);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;
        $data = [
            'access_token' => $authToken,
            'user' => Auth::user(),
            'success' => true,
        ];
        return $this->successResponse($data, 'Login success.');
        // ->withCookie(
        //     'jwt', $authToken
        // );
    }
    public function login_page(){
        return view('auth.login');
    }
    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            $message = 'Successfully logged out';
            return $this->successResponse(null, $message);
        } catch (\Illuminate\Database\QueryException $ex) {
            $message = $ex->getMessage();
            return $this->errorResponse($message, 422);
        }
    }
    /**
     * Current User
     */
    public function user(Request $request){
        $user = $request->user();
        return $this->successResponse([ 'user' => $user], 'Current User');
    }
}