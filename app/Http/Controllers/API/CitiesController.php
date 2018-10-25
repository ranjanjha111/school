<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\City;

class CitiesController extends Controller
{
    /*
     * Get list of city by state
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getCityByState(Request $request) {
        $validator = Validator::make($request->all(), [
            'state_id'  => 'required|numeric'
        ]);

        if($validator->fails()) {
            $errors = json_decode($validator->errors());
            foreach($errors as $error) {
                $message    = $error[0];
            }
            $response['result']     = 'error';
            $response['message']    = $message;
            return response()->json($response);
        }

        $city   = new City();
        $data   = $city->getCityByStateId($request->state_id);
        if(!empty($data)) {
            $response['result']     = 'success';
            $response['message']    = '';
            $response['data']       = $data;
        } else {
            $response['result']     = 'success';
            $response['message']    = 'No city found.';
            $response['data']       = array();
        }

        return response()->json($response);
    }
}
