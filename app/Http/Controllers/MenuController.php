<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    public function refreshAllMenus()
    {
        $allMenus = Menu::get(['name', 'parent_id', 'id']);
        return response()->json($allMenus);
    }


    /**    /**
     * Display the tree's of Menu's option
     *
     * @return \Illuminate\Http\Response
     */
    public function getMenuTreeView()
    {
        $menus = Menu::whereNull('parent_id')->get();
        $menus->load('childs');
        return view('menus.admin-treeView',compact('menus'));
    }

    /**
     * Display the main screen of the app.
     *
     * @return \Illuminate\Http\Response
     */
    public function configuration()
    {
        $menus = Menu::whereNull('parent_id')->get();
        $menus->load('childs');
        $allMenus = Menu::pluck('name','id')->all();
        return view('menus.admin-config',compact('menus'));
    }


    /**
     * get the menu option's url to display report in main layout.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayReport(Request $request)
    {
        $menu_id = $request->post('params')['menu_id'];
        $menu = Menu::where( 'id' , '=' , $menu_id )->first();
        $url = $menu->url;
        return view('menus.menuReport',compact('url'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {
        //$menus = Menu::menus();
        $menus = Menu::menus( Auth::id() );
        return view('menus.main',compact('menus'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = new Menu();

        $menu->name = $request->post('params')['name'];
        $menu->url = $request->post('params')['url'];
        $menu->parent_id = $request->post('params')['parent_id'];
        $menu->enabled = $request->post('params')['enabled'];
        $menu->save();

        return $this->getMenuTreeView();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $menu_id = $request->post('params')['menu_id'];
        $menu = Menu::where( 'id' , '=' , $menu_id )->first();
        return response()->json( $menu );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $menu_id = $request->post('params')['id'];
        $menu = Menu::where( 'id' , '=' , $menu_id )->first();

        $menu->name = $request->post('params')['name'];
        $menu->url = $request->post('params')['url'];
        $menu->parent_id = $request->post('params')['parent_id'];
        $menu->enabled = $request->post('params')['enabled'];
        $menu->save();

        return $this->getMenuTreeView();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $menu_id = $request->post('params')['menu_id'];
        $menu = Menu::where( 'id' , '=' , $menu_id )->delete();
        return $this->getMenuTreeView();
    }
}
