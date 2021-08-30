<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allMenus = Menu::whereNull('parent_id')->get();
        $users = User::all();
        $users->load('roles');
        $roles = Role::pluck('name','name')->all();
        return view('users.index',compact('users','allMenus','roles'));
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
        //$password = $request->post('params')['password'] == "" ? "abc123" : $request->post('params')['password'];

        if( isset($request->post('params')['password']) && ( $request->post('params')['password'] != "" ) ) {
            $password = $request->post('params')['password'];
        } else {
            $password = "abc123";
        }

        $user = new User();
        $user->name = $request->post('params')['name'];
        $user->email = $request->post('params')['email'];
        $user->password = Hash::make( $password );
        $user->enabled = $request->post('params')['enabled'];
        $user->save();

        $menuList = $request->post('params')['menuList'];
        if( Str::length($menuList) > 0 ){
            $menuArr = explode('|',$menuList);
            if( count($menuArr) != 0 ) {
                $user->menus()->sync($menuArr);
            } else {
                $user->menus()->detach();
            }
        } else {
            $user->menus()->detach();
        }

        /*  Asume que se chequeo en el front-end que no venga vacío.   */
        $role = $request->post('params')['role'];
        $arrRole = array('name' => $role);
        $user->syncRoles($arrRole);

        $response = array(
            'status' => 'success',
            'response_code' => 200
        );
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile',compact('user'));
    }

    public function changePassword(Request $request)
    {
        if( isset($request->post('params')['password']) && ( $request->post('params')['password'] != "" ) ) {
            $password = $request->post('params')['password'];
        } else {
            $password = "abc123";
        }

        $user = User::where('id','=', Auth::id() )->first();
        $user->password = Hash::make( $password );
        $user->save();

        $response = array(
            'status' => 'success',
            'response_code' => 200
        );
        return response()->json($response);
    }



    // --------------- [ Upload Image ] -------------------
    public function uploadImage(Request $request) {

        $image = $request->file('file');
        $newImageName = time(). ".". $image->extension();

        $aux = $image->storeAs( '/public/profiles' , $newImageName );
        $newPathfilename = asset('storage').'/profiles/'.$newImageName;

        $user_id = Auth::id();
        $user = User::where('id','=',$user_id)->first();
        $oldImageName = $user->image;
        $user->image = $newImageName;
        $user->save();

        if ($oldImageName != 'icon-user-default.png') {
            if( Storage::disk('public')->exists( '/profiles/'.$oldImageName ) ) {
                Storage::disk('public')->delete('/profiles/'.$oldImageName );
            }
        }

        $response = array(
            'status' => 'success',
            'response_code' => 200,
            'pathfilename' => $newPathfilename,
        );
        return response()->json($response);
    }


    public function previewImage(Request $request) {

        $image = $request->file('file');
        $imageName = time(). ".". $image->extension();

        $aux = $image->storeAs( '/public/tmp' , $imageName );
        $pathfilename = asset('storage').'/tmp/'.$imageName;

        $response = array(
            'status' => 'success',
            'response_code' => 200,
            'pathfilename' => $pathfilename,
        );
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user_id = $request->post('params')['id'];
        $user = User::where('id','=',$user_id)->first();
        //$userRole = $user->roles->pluck('name','name')->all();
        $user->load('menus');
        $user->load('roles');
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = $request->post('params')['id'];
        $user = User::where( 'id' , '=' , $user_id )->first();

        $user->name = $request->post('params')['name'];
        $user->email = $request->post('params')['email'];
        $user->enabled = $request->post('params')['enabled'];
        $user->save();

        $menuList = $request->post('params')['menuList'];
        if( Str::length($menuList) > 0 ){
            $menuArr = explode('|',$menuList);
            if( count($menuArr) != 0 ) {
                $user->menus()->sync($menuArr);
            } else {
                $user->menus()->detach();
            }
        } else {
            $user->menus()->detach();
        }

        /*  Asume que se chequeo en el front-end que no venga vacío.   */
        $role = $request->post('params')['role'];
        $arrRole = array('name' => $role);
        $user->syncRoles($arrRole);

        $response = array(
            'status' => 'success',
            'response_code' => 200
        );
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id = $request->post('params')['id'];
        User::where( 'id' , '=' , $user_id )->delete();
        return $this->index();
    }

}
