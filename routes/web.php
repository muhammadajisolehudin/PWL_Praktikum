<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home',[App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');



//akses admin home
Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])
->name('admin.home')
->middleware('is_admin');


//untuk menampilkan (mengambil data)
Route::get('admin/books', [App\Http\Controllers\AdminController::class, 'books'])
->name('admin.books')
->middleware('is_admin');

//PENGELOLAAN BUKU

//membuat/menambah buku
Route::post('admin/books', [App\Http\Controllers\AdminController::class, 'submit_book'])
->name('admin.book.submit')
->middleware('is_admin');

//mengubah data buku
Route::patch('admin/books/update', [App\Http\Controllers\AdminController::class, 'update_book'])
->name('admin.book.update')
->middleware('is_admin');

//MENAMPILKAN DATA DI FORM UPDATE
Route::get('admin/ajaxadmin/dataBuku/{id}', [App\Http\Controllers\AdminController::class, 'getDataBuku']);

//menghapus
Route::post('admin/books/delete/{id}',[App\Http\Controllers\Admincontroller::class, 'delete_book'])
->name('admin.book.delete')
->middleware('is_admin');

//print PDF
Route::get('admin/print_books', [App\Http\Controllers\AdminController::class, 'print_books'])
->name('admin.print.books')
->middleware('is_admin');

//export excel
Route::get('admin/books/export', [App\Http\Controllers\AdminController::class, 'export'])
->name('admin.book.export')
->middleware('is_admin');

//import excel
Route::post('admin/books/import', [App\Http\Controllers\AdminController::class, 'import'])
->name('admin.book.import')
->middleware('is_admin');