<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    //

    public function index(Request $request)
    {
        $categories = Category::all();


        if ($request->category || $request->title) {
            $books = Book::where('title', 'like', '%' . $request->title . '%')
                ->orWhereHas('categories', function ($query) use ($request) {
                    $query->where('categories.id', $request->category);
                })->get();
        } else {
            $books = Book::all();
        }


        return view('public.book-list', ['books' => $books, 'categories' => $categories]);
    }
}
