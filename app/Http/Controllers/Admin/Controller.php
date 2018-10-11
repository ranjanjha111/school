<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use View;
use App\Menu;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function guard(){
        return Auth::guard('admin');
    }

    public function __construct()
    {
        $guardName  = array(
            'admin' => 'Admin',
            'web'   => 'Web'
        );

        $status     = array(
            ''      => 'Please select a status',
            '0'     => 'Inactive',
            '1'     => 'Active'
        );

        $showRecords    = array(
            '10'    => 10,
            '25'    => 25,
            '50'    => 50,
            '100'   => 100
        );

        View::share('status', $status);
        View::share('showRecords', $showRecords);
        View::share('guardName', $guardName);
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
