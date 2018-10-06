<?php

namespace App;

class Permission extends \Spatie\Permission\Models\Permission
{
    public static function defaultPermissions()
    {
        return [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',
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
