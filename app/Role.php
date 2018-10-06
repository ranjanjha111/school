<?php

namespace App;

class Role extends \Spatie\Permission\Models\Role
{

    /*
     * Get list of all role.
     */
    public function getAllRole() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $role       = Role::select('*');
        if(request()->has('search')) {
            $role   = $role->where('name', 'like', '%' . request()->get('search') . '%');
        }

        return $role->paginate();
    }
}
