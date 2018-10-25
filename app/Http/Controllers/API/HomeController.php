<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/22/2018
 * Time: 10:28 AM
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class HomeController
{
    /**
     * Parents Home page screen.
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
}