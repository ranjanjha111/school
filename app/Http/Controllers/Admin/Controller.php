<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $status     = array(
            ''      => 'Please select a status',
            '0'     => 'Inactive',
            '1'     => 'Active'
        );

//        $showRecords    = array(
//            '10'    => 10,
//            '25'    => 25,
//            '50'    => 50,
//            '100'   => 100
//        );

        $showRecords    = array(
            '1'     => 1,
            '2'     => 2,
            '3'     => 3,
            '4'     => 4
        );

//        $languages  = request()->session()->get('languages');

        View::share('status', $status);
        View::share('showRecords', $showRecords);

    }

    public function validateTranslator($request, $langValidation = array(), $normalValidation = array()) {
        $validation = array();
        foreach(request()->session()->get('languages') as $local => $language) {
            foreach ($langValidation as $name => $rule) {
                $validation[$local . '_' . $name]    = $rule;
            }
        }
        foreach($normalValidation as $name => $rule) {
            $validation[$name] = $rule;
        }

        $this->validate($request, $validation);
    }

    /*
     * Set number of records per page.
     */
    public function setPerPage($records = 10) {
    }
}
