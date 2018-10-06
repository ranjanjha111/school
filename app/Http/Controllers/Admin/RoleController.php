<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Authorizable;
use App\Permission;
use App\Role;

class RoleController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role   = new Role();
        $roles  = $role->getAllRole();

        $permission     = new Permission();
        $permissions    = $permission->getAllPermission();

        if (request()->ajax()) {
            return view('admin.role.load', ['roles' => $roles, 'permissions' => $permissions])->render();
        }

        return view('admin.role.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.role.new', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles']);
        if(Role::create($request->only('name'))) {
            $request->session()->flash('success', 'Role has been created successfully.');
        } else {
            $request->session()->flash('danger', 'Role has not been created.');
        }

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role           = Role::find($id);
        $permissions    = Permission::all();
        if (request()->ajax()) {
            return view('admin.role.show', ['role' => $role, 'permissions' => $permissions, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role           = Role::find($id);
        $permissions    = Permission::all();

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($role = Role::findOrFail($id)) {
            // admin role has everything
            if($role->name === 'Admin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('roles.index');
            }
            $permissions = $request->get('permissions', []);
            $role->syncPermissions($permissions);
            $request->session()->flash('success', $role->name . ' permission has been updated successfully.');
        } else {
            $request->session()->flash('danger', $role->name . ' permission has not been updated.');
        }

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if(Role::findOrFail($id)->delete() ) {
            request()->session()->flash('success', 'Role has been deleted.');
        } else {
            request()->session()->flash('danger', 'Role has not been deleted.');
        }

        return redirect()->back();
    }
}
