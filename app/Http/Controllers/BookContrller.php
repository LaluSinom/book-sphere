<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookContrller extends Controller
{
    //index
    public function index(Request $request)
    {
        $books = DB::table('books')
        ->join('categoryB', 'books.categoryB_id', '=', 'categoryB.id')
        ->select('books.*', 'categoryB.name as category_name')
        ->when($request->keyword, function($query) use($request) {
            $query->where('title', 'like', "%{$request->keyword}%")
            ->orWhere('author', 'like', "%{$request->keyword}%")
            ->orWhere('publisher', 'like', "%{$request->keyword}%")
            ->orWhere('year', 'like', "%{$request->keyword}%")
            ->orWhere('categoryB.name', 'like', "%{$request->keyword}%");
        })->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    //create
    public function create()
    {
        $categories = DB::table('categoryB')->get();
        return view('admin.books.create', compact('categories'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'categoryB_id' => 'required|exists:categoryB,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'phone_author' => 'required|integer',
            'publisher' => 'required|string|max:255',
            'price' => 'required|integer',
            'tumbnail' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $tumbnail = null;
        if ($request->file('tumbnail')) {
            $tumbnail = $request->file('tumbnail')->store('tumbnails', 'public');
        }

        Book::create([
            'categoryB_id' => $request->categoryB_id,
            'title' => $request->title,
            'author' => $request->author,
            'phone_author' => $request->phone_author,
            'publisher' => $request->publisher,
            'price' => $request->price,
            'tumbnail' => $tumbnail,
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    //edit
    public function edit($id)
    {
        $book = Book::find($id);
        $categories = DB::table('categoryB')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    //update
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        $request->validate([
            'categoryB_id' => 'required|exists:categoryB,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'phone_author' => 'required|integer',
            'publisher' => 'required|string|max:255',
            'price' => 'required|integer',
            'tumbnail' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $tumbnail = $book->tumbnail;
        if ($request->file('tumbnail')) {
            if ($tumbnail && file_exists(storage_path('app/public/' . $tumbnail))) {
                Storage::delete('public/' . $tumbnail);
            }
            $tumbnail = $request->file('tumbnail')->store('tumbnails', 'public');
        }

        $book->update([
            'categoryB_id' => $request->categoryB_id,
            'title' => $request->title,
            'author' => $request->author,
            'phone_author' => $request->phone_author,
            'publisher' => $request->publisher,
            'price' => $request->price,
            'tumbnail' => $tumbnail,
        ]);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    //destroy
    public function destroy(Book $book)
    {
        $tumbnail = $book->tumbnail;
        if ($tumbnail && file_exists(storage_path('app/public/' . $tumbnail))) {
            Storage::delete('public/' . $tumbnail);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
