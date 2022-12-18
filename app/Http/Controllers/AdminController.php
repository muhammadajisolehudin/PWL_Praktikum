<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//yang ditambahkan 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

use App\Models\Book;

use PDF;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport; 
use App\Imports\BooksImport;

class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
    }
    

      //untuk mengaksess buku
      public function books(){
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
    }

    //function create/tambah buku
    public function submit_book(Request $req){
        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);

        $book = new book;

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if($req->hasFile('cover')){
            $extension = $req->file('cover')->extension();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );

            $book->cover = $filename;
        }

        $book->save();

        $notification = array(
            'message' => 'Data buku berhasil ditambah',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }

    //AJAX PROCCES
      public function getDataBuku($id){
        $buku = Book::find($id);
        return response()->json($buku);
    }

    //function update buku
    public function update_book(Request $req){
        $book = Book::find($req->get('id'));

        $validate = $req->validate([
            'judul'=> 'required|max:225',
            'penulis'=> 'required',
            'tahun'=> 'required',
            'penerbit'=> 'required',
        ]);

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if($req->hasfile('cover')){
            $extension = $req->file('cover')->extension();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );

            Storage::delete('public/cover_buku/'.$req->get('old_cover'));

            $book->cover = $filename;
        }

        $book->save();
        $notification = array(
            'message' => 'Data buku berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);


    }

    //function delete book
    public function delete_book($id){
        $book = Book::find($id);
        Storage::delete('public/cover_buku/'.$book->cover);
        $book->delete();

        $success = true;
        $message = "Data buku berhasil dihapus";

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    //function print PDF
    public function print_books(){
        $books = Book::all();

        $pdf = PDF::loadview('print_books' ,['books'=>$books]);
        return $pdf->download('data_buku.pdf');
    }

    //function export excel
    public function export(){
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    //function impoet excel
    public function import(Request $req){
        Excel::import(new BooksImport, $req->file('file'));

        $notification = array(
            'message' => 'import data berhasil dilakukan',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.books')->with($notification);
    }
}
