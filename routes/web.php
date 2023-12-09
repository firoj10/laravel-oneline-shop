<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\CategoryControlle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/login',[AdminLoginController::class,'index'])->name('admin.login');

Route::group(['prefix'=> 'admin'], function(){
    Route::group(['middileware'=> 'admin.guest'],function(){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
 
    });
    Route::group(['middileware'=> 'admin.auth'],function(){
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');
        // category Route
        Route::get('/categories',[CategoryControlle::class,'index'])->name('categories.index');
        Route::get('/categories/create',[CategoryControlle::class,'create'])->name('categories.create');
        Route::post('/categories',[CategoryControlle::class,'store'])->name('categories.store');

        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status'=> true,
                'slug'=> $slug,
            ]);
        })->name('getSlug');

    });
});











