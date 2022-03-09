<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


//  student  routes.
// */
Route::group([

    'namespace' => 'App\Http\Controllers',

], function () {
    
    Route::get('/', 'StudentController@index');
    Route::post('store-input-fields', 'StudentController@store');
    Route::get('place/{countryId}', 'StudentController@place');
    Route::get('list', 'StudentController@list');
    Route::get('Upload', 'StudentController@upload');
});
