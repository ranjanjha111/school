<?php

namespace App;

class Permission extends \Spatie\Permission\Models\Permission
{

    public function menu() {
        return $this->hasMany('App\Menu');
    }

    public static function defaultPermissions()
    {
        return [
            'view_dashboard',
            'add_dashboard',
            'edit_dashboard',
            'delete_dashboard',

            'view_languages',
            'add_languages',
            'edit_languages',
            'delete_languages',

            'view_states',
            'add_states',
            'edit_states',
            'delete_states',

            'view_city',
            'add_city',
            'edit_city',
            'delete_city',

            'view_menus',
            'add_menus',
            'edit_menus',
            'delete_menus',

            'view_admins',
            'add_admins',
            'edit_admins',
            'delete_admins',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            //For guardians
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',
        ];
    }


    /*
     * Get list of all permission.
     */
    public function getAllPermission() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $permission = Permission::select('*');
        if(request()->has('search')) {
            $permission = $permission->where('name', 'like', '%' . request()->get('search') . '%');
        }

        return $permission->paginate();
    }

}
