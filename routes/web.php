<?php

use App\Http\Controllers\AmazoneTextractController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::match(array('GET','POST'),'aws/fileUpload', [AmazoneTextractController::class,'fileUpload'])->name('aws.fileUpload');
Route::match(array('GET','POST'),'aws/extract', [AmazoneTextractController::class,'index'])->name('aws.extract');
