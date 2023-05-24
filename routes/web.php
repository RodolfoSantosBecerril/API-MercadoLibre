<?php
use App\Http\Controllers\MercadoLibreController;
use Illuminate\Support\Facades\Route;

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
 
 
Route::get('/redirect', [MercadoLibreController::class, 'autorize']);
Route::get('/mercadolibre/authorize', [MercadoLibreController::class, 'autorize']);
Route::get('/mercadolibre/callback', [MercadoLibreController::class, 'callback']);
