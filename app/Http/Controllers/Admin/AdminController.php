<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Authorizable;
use App\Role;
use App\Permission;
use App\AdminUser;

class AdminController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin  = new AdminUser();
        $result = $admin->getAllAdmin();

        if (request()->ajax()) {
            return view('admin.admin.load', ['result' => $result])->render();
        }

        return view('admin.admin.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $role           = Role::where('name', Auth::guard('admin')->user()->getRoleNames())->first();
        $roles          = Role::where('guard_name', 'admin')->pluck('name', 'id');
        $permissions    = Permission::where('guard_name')->get();

        return view('admin.admin.new', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'bail|required|min:2',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'roles'     => 'required|min:1',
            'status'    => 'required'
        ]);

        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);

        // Create the user
        if ( $admin = AdminUser::create($request->except('roles', 'permissions')) ) {
            $this->syncPermissions($request, $admin);
            $request->session()->flash('success', 'User created successfully.');
        } else {
            $request->session()->flash('danger', 'User could not be created.');
        }

        return redirect()->route('admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user           = AdminUser::findOrFail($id);
        $role           = Role::where('guard_name', 'admin')->where('name', $user->getRoleNames())->first();
        $permissions    = Permission::where('guard_name', 'admin')->get();
        if (request()->ajax()) {
            return view('admin.admin.show', ['user' => $user, 'role' => $role, 'permissions' => $permissions, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.admin.show', compact('role'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user   = AdminUser::findOrFail($id);

        //Need to refactor below code.
        $role   = Role::where('name', $user->getRoleNames())->first();
        $roles = Role::where('guard_name', 'admin')->pluck('name', 'id');
        $permissions    = Permission::where('guard_name', $role->guard_name)->get();

        return view('admin.admin.edit', compact('user', 'role', 'roles', 'permissions'));
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
        $this->validate($request, [
            'name'      => 'bail|required|min:2',
            'email'     => 'required|email|unique:users,email,' . $id,
            'roles'     => 'required|min:1',
            'status'    => 'required'
        ]);

        // Get the user
        $admin  = AdminUser::findOrFail($id);

        // Update user
        $admin->fill($request->except('roles', 'permissions', 'password'));

        // check for password change
        if($request->get('password')) {
            $admin->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $admin);
        if($admin->save()) {
            $request->session()->flash('success', 'User has been updated successfully.');
        } else {
            $request->session()->flash('danger', 'User has not been updated.');
        }

        return redirect()->route('admins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( $this->guard()->user()->id == $id ) {
            request()->session()->flash('danger', 'Deletion of currently logged in user is not allowed');
            return redirect()->back();
        }

        if(AdminUser::findOrFail($id)->delete()) {
            request()->session()->flash('success', 'User deleted successfully.');
        } else {
            request()->session()->flash('danger', 'User could not be deleted.');
        }

        return redirect()->back();
    }

    /**
     * Sync roles and permissions
     *
     * @param Request $request
     * @param $admin
     * @return string
     */
    private function syncPermissions(Request $request, $admin)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if( ! $admin->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $admin->permissions()->sync([]);
        } else {
            // handle permissions
            $admin->syncPermissions($permissions);
        }

        $admin->syncRoles($roles);

        return $admin;
    }
}
