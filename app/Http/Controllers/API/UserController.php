<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @param   string $email
     * @param   string $password
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|email',
            'password'  => 'required|string'
        ]);
        if ($validator->fails()) {
            $errors = json_decode($validator->errors());
            foreach($errors as $error) {
                $message    = $error[0];
            }
            $response['result']     = 'error';
            $response['message']    = $message ?? '';

            return response()->json($response);
        }

        if(Auth::attempt(request(['email', 'password']))) {
            $user                   = $request->user();
            $response['result']     = 'success';
            $response['message']    = 'Logged in successfully';
            $response['token']      = $user->createToken('MyApp')->accessToken;
            $response['data']       = $user;
        } else {
            $response['result']     = 'error';
            $response['message']    = 'Invalid Credential. Plesae try again.';
        }

        return response()->json($response);
    }

    /**
     * User profile api
     *
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        $user       = Auth::guard('api')->user();
        if(!empty($user)) {
            $response['result']     = 'success';
            $response['message']    = '';
            $response['data']       = $user;
        } else {
            $response['result']     = 'error';
            $response['message']    = 'Please login first to view your profile.';
            $response['data']       = array();
        }
        return response()->json($response);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $user   = Auth::guard('api')->user();
        if(!empty($user)) {
            $user->token()->revoke();
            $response['result']     = 'success';
            $response['message']    = 'Successfully logged out';
            $response['data']       = array();
        } else {
            $response['result']     = 'error';
            $response['message']    = 'Please login first.';
            $response['data']       = array();
        }

        return response()->json($response);
    }
}
