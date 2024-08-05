<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\PagesController;

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

Route::get('/index/home', [PagesController::class, 'home'])->name('index/home');
Route::post('/index/home', [PagesController::class, 'store']);
Route::get('/template', [PagesController::class, 'template']);


Auth::routes();

Route::group(['prefixe' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('/categorie', CategoryController::class);
    Route::patch('/categorie/{id}/desactivate', [CategoryController::class, 'desactivate'])->name('categorie.desactivate');
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
    Route::get('/candidatures/show/{id}', [CandidatureController::class, 'show'])->name('candidatures.show');
    Route::get('/candidatures/{id}/pdf', [CandidatureController::class, 'showPdf'])->name('candidatures.showPdf');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
    Route::resource('/entretiens', InterviewController::class);
    Route::patch('/entretiens/{id}/statut', [InterviewController::class, 'updateStatut'])->name('entretiens.updateStatut');
});
