<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Support\Facades\Response;

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

//Route::get('/dashboard',[AdminController::class,''];
Route::get('/dashboard',[AdminController::class,'dashBoard']);

/* ->middleware(['auth'])->name('dashboard')
 */
require __DIR__.'/auth.php';
Route::get('/assets',[AdminController::class,'assetHome']);
Route::get('/asset-type',[AdminController::class,'assetType']);
Route::get('/asset',[AdminController::class,'asset']);
Route::get('/asset-type-form',[AdminController::class,'assetTypeForm']);
Route::post('/asset-type-form',[AdminController::class,'assetTypeFormPost']);
Route::post('/asset-type-form-update',[AdminController::class,'updateAssetType']);
Route::get('/asset-type/delete/{id}',[AdminController::class,'deleteAssetType']);
Route::get('/edit/{id}',[AdminController::class,'editAssetType'])->name('assettype.edit');
Route::post('/update/{id}',[AdminController::class,'updateAssetType'])->name('assettype.update');
Route::get('/editasset/{id}',[AdminController::class,'editAsset'])->name('asset.edit');
Route::post('/updateasset/{id}',[AdminController::class,'updateAsset'])->name('asset.update');
Route::get('/asset-form',[AdminController::class,'assetForm']);
Route::post('/asset-form',[AdminController::class,'assetFormPost']);
Route::get('/asset/delete/{id}',[AdminController::class,'deleteAsset']);
