<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Authorizable;
use App\Menu;
use Illuminate\Support\Facades\Auth;


class MenuController extends Controller
{
//    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu   = new Menu();
        $result = $menu->getAllMenu();

        if (request()->ajax()) {
            return view('admin.menu.load', ['result' => $result])->render();
        }

        return view('admin.menu.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu           = new Menu();
        $menu_id        = $menu->getRootMenuList();
        $permission_id  = [0 => 'Please select Permission'] + Permission::where('guard_name', 'admin')->pluck('name', 'id')->toArray();

        return view('admin.menu.new', compact('menu_id', 'permission_id'));
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
            'name'          => 'required|min:2|unique:menus,name',
            'menu_id'       => 'required',
            'permission_id' => 'required',
            'status'        => 'required'
        ]);

        $data   = $request->all();
        $data['created_by'] = Auth::guard('admin')->user()->id;

        // Create the user
        if ( $menu = Menu::create($data) ) {
            $request->session()->flash('success', 'Menu created successfully.');
        } else {
            $request->session()->flash('danger', 'Menu could not be created.');
        }

        return redirect()->route('menus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu   = Menu::findOrFail($id);

        if (request()->ajax()) {
            return view('admin.menu.show', ['menu' => $menu, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu       = Menu::findOrFail($id);
        $menuObj    = new Menu();
        $menu_id    = $menuObj->getRootMenuList();

        $permission_id  = [0 => 'Please select Permission'] + Permission::where('guard_name', 'admin')->pluck('name', 'id')->toArray();

        return view('admin.menu.edit', compact('menu', 'menu_id', 'permission_id'));
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
            'name'          => 'required|min:2|unique:menus,name,' . $id,
            'menu_id'       => 'required',
            'permission_id' => 'required',
            'status'        => 'required'
        ]);

        $menu   = Menu::find($id);
        $menu->fill($request->all());
        if($menu->save()) {
            $request->session()->flash('success', 'Menu updated successfully.');
            return redirect()->route('menus.index');
        } else {
            $request->session()->flash('danger', 'Menu could not be updated.');
            return redirect()->route('menus.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Menu::findOrFail($id)->delete()) {
            request()->session()->flash('success', 'Menu deleted successfully.');
        } else {
            request()->session()->flash('danger', 'Menu could not be deleted.');
        }

        return redirect()->back();
    }
}
