<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/******************************************************* */
/*       CODIGO FUNCIONANDO OK: 2021-08-27 23:59:00      */
/******************************************************* */
/*

Route::get('/symunlink', function () {
    $linkFolder = '/home/domilia1/public_html/atenea/storage';
    echo 'linkFolder: '.$linkFolder.'<br>';
    unlink($linkFolder);
});


Route::get('/symlink', function () {

    $targetFolder = '/home/domilia1/finanzas/atenea/storage/app/public';
    echo 'targetFolder: '.$targetFolder.'<br>';

    $linkFolder = '/home/domilia1/public_html/atenea/storage';
    echo 'linkFolder: '.$linkFolder.'<br>';

    if( file_exists($targetFolder) ) {
        echo 'SI existe el path: '.$targetFolder.'<br>';
    } else {
        echo 'NO existe el path: '.$targetFolder.'<br>';
    }

    if( file_exists($linkFolder) ) {
        echo 'SI existe el path: '.$linkFolder.'<br>';
    } else {
        echo 'NO existe el path: '.$linkFolder.'<br>';
    }

    if( symlink($targetFolder,$linkFolder) ) {
        echo 'Symlink process successfully completed'.'<br>';
        echo readlink($linkFolder);
    } else {
        echo 'Symlink DO NOT process'.'<br>';
    }

});

*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\MenuController::class, 'main'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::post('/menus/displayReport', [App\Http\Controllers\MenuController::class, 'displayReport'])->name('menus.displayReport');
    Route::post('/menus/configuration', [App\Http\Controllers\MenuController::class, 'configuration'])->name('menus.configuration');
    Route::post('/menus/getMenuTreeView', [App\Http\Controllers\MenuController::class, 'getMenuTreeView'])->name('menus.getMenuTreeView');
    Route::post('/menus/store', [App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
    Route::post('/menus/edit', [App\Http\Controllers\MenuController::class, 'edit'])->name('menus.edit');
    Route::post('/menus/update', [App\Http\Controllers\MenuController::class, 'update'])->name('menus.update');
    Route::post('/menus/destroy', [App\Http\Controllers\MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('/menus/refreshAllMenus', [App\Http\Controllers\MenuController::class, 'refreshAllMenus'])->name('menus.refreshAllMenus');

    Route::post('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::post('/users/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::post('/users/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');
    Route::post('/users/upload-image', [App\Http\Controllers\UserController::class, 'uploadImage'])->name('users.upload-image');
    Route::post('/users/preview-image', [App\Http\Controllers\UserController::class, 'previewImage'])->name('users.preview-image');
    Route::post('/users/changePassword', [App\Http\Controllers\UserController::class, 'changePassword'])->name('users.chagePassword');

});
