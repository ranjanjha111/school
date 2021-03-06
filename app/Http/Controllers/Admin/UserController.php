<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Authorizable;
use App\Role;
use App\Permission;
use App\User;

class UserController extends Controller
{
//    use Authorizable;

//    protected $guard = 'web';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user   = new User();
        $result = $user->getAllUser();

        if (request()->ajax()) {
            return view('admin.user.load', ['result' => $result])->render();
        }

        return view('admin.user.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles          = Role::where('guard_name', 'web')->pluck('name', 'id');
        $permissions    = Permission::where('guard_name')->get();

        return view('admin.user.new', compact('roles', 'permissions'));
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
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'roles'     => 'required|min:1',
            'status'    => 'required'
        ]);

        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);

        // Create the user
        if ( $user = User::create($request->except('roles', 'permissions')) ) {
            $this->syncPermissions($request, $user);
            $request->session()->flash('success', 'User created successfully.');
        } else {
            $request->session()->flash('danger', 'User could not be created.');
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user           = User::findOrFail($id);
        $role           = Role::where('guard_name', 'web')->where('name', $user->getRoleNames())->first();
        $permissions    = Permission::where('guard_name', 'web')->get();
        if (request()->ajax()) {
            return view('admin.user.show', ['user' => $user, 'role' => $role, 'permissions' => $permissions, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.user.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user           = User::findOrFail($id);

        //Need to refactor below code.
        $role           = Role::where('name', $user->getRoleNames())->first();
        $roles          = Role::where('guard_name', 'web')->pluck('name', 'id');
        $permissions    = Permission::where('guard_name', $role->guard_name)->get();

        return view('admin.user.edit', compact('user', 'role', 'roles', 'permissions'));
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
        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password'));

        // check for password change
        if($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $user);
        if($user->save()) {
            $request->session()->flash('success', 'User has been updated successfully.');
        } else {
            $request->session()->flash('danger', 'User has not been updated.');
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id)
    {
        if(User::findOrFail($id)->delete()) {
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
     * @param $user
     * @return string
     */
    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }
}
