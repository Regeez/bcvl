<?php


use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;

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


// Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
// require __DIR__ . '/auth.php';

Route::redirect('/', '/home');
Auth::routes();

// Route::resource('/class', ClassroomController::class);
Route::resource('/class', ClassroomController::class)->parameters(['class' => 'id']);
Route::put('/add-student', [ClassroomController::class, 'edit'])->name('edit');

//attach student
Route::put('/class/{classroomId}/{studentId}', [ClassroomController::class, 'insertStudent'])->name('class.insertStudent');
//detach student
Route::delete('/class/{classroomId}/{studentId}', [ClassroomController::class, 'removeStudent'])->name('class.removeStudent');

Route::resource('/announcement', PostController::class)->parameters(['announcement' => 'id']);
Route::get('/download/{id}', [DownloadController::class, 'download'])->name('download');


Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/home', [HomeController::class, 'index'])->name('home');
