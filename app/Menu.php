<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;


class Menu extends Model
{
    const ROOT_MENU_ID  = 0;

    public static $action = [
        'view'      => 'index',
        'add'       => 'store',
        'edit'      => 'edit',
        'delete'    => 'delete'
    ];


    protected $fillable = [
        'name', 'menu_id', 'permission_id', 'menu_order', 'image', 'status', 'created_by', 'updated_by'
    ];

    public function rootMenu() {
        return $this->belongsTo('App\Menu','menu_id');
    }

    public function subMenu() {
        return $this->hasMany('App\Menu');
    }

    public function menuRoutes() {
        return $this->belongsTo('App\Permission', 'permission_id');
    }

    /*
     * Get list of all menu.
     */
    public function getAllMenu() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $menu       = Menu::select('*');
        if(request()->has('search')) {
            $menu   = $menu->where('name', 'like', '%'. request()->get('search') .'%');
        }

        return $menu->paginate();
    }

    /*
     * Get Root menu.
     */
    public function getRootMenu() {
        return Menu::where('status', '1')->where('menu_id', self::ROOT_MENU_ID)->get();
    }


    /*
     * Get list of root menu as an array with id, name as key value.
     */
    public function getRootMenuList() {
        $rootMenu   = Menu::where('status', '1')->where('menu_id', self::ROOT_MENU_ID)->pluck('name', 'id')->toArray();
        return [0 => 'Select Root Menu'] + $rootMenu;
    }

    /*
     * Get menu route.
     */
    public static function getAdminMenu() {
        $menus  = Menu::where('status', '1')->where('menu_id', self::ROOT_MENU_ID)->get();
        $menuList   = array();
        foreach($menus as $key => $menu) {
            if($menu->submenu()->where('status', '1')->count()) {
                $menuList[$key]['name']       = $menu->name;
                $menuList[$key]['image']      = $menu->image;

                $menuList[$key]['hasSubMenu'] = true;
                foreach($menu->subMenu()->where('status', '1')->get() as $subMenu) {
                    $link   = '';
                    if($subMenu->menuRoutes()->count()) {
                        $routeName  = $subMenu->menuRoutes()->first()->name;
                        $resource   = substr(strstr($routeName, '_'),  1);
                        $action     = strstr($routeName, '_', true);
                        $link   = $resource . '.' . self::$action[$action];
                    }

                    $menuList[$key]['subMenu'][]    = array(
                        'name'          => $subMenu->name,
                        'permission'    => $routeName,
                        'routeName'     => $link
                    );
                }
            } else {
                $routeName  = $menu->menuRoutes()->first()->name;
                $resource   = substr(strstr($routeName, '_'),  1);
                $action     = strstr($routeName, '_', true);

                $menuList[$key]['name']       = $menu->name;
                $menuList[$key]['permission'] = $routeName;
                $menuList[$key]['image']      = $menu->image;
                $menuList[$key]['hasSubMenu'] = false;
                $menuList[$key]['routeName']  = $resource . '.' . self::$action[$action];
            }
        }

        return $menuList;
    }
}
