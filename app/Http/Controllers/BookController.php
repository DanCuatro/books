<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller{

    public function index(Request $request){
        $book = Book::orderBy('name')->paginate(5);
        return $book;
    }

    public function store(Request $request){
        $book               = new Book();
        $book->name         = $request->name;
        $book->editorial    = $request->editorial;
        $book->author       = $request->author;
        $book->sheets       = $request->sheets;
        $book->save();
    }

    public function show(Request $request){
        $book = Book::findOrFail($request->id);
        return $book;
    }

    public function update(Request $request){
        $book               = Book::findOrFail($request->id);
        $book->name         = $request->name;
        $book->editorial    = $request->editorial;
        $book->author       = $request->author;
        $book->sheets       = $request->sheets;
        $book->save();
        return $book;
    }

    public function destroy(Request $request){
        $book = Book::destroy($request->id);
        return $book;
    }
}
