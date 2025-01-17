<?php

namespace App\Http\Controllers;

use App\Models\EbooksModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EbooksController extends Controller
{
    //index
    public function index(Request $request)
    {   
        $ebooks = DB::table('ebooks')
            ->join('category', 'ebooks.category_id', '=', 'category.id')
            ->select('ebooks.*', 'category.name as category_name')
            ->when($request->keyword, function($query) use($request) {
                $query->where('title', 'like', "%{$request->keyword}%")
                    ->orWhere('author', 'like', "%{$request->keyword}%")
                    ->orWhere('publisher', 'like', "%{$request->keyword}%")
                    ->orWhere('year', 'like', "%{$request->keyword}%")
                    ->orWhere('category.name', 'like', "%{$request->keyword}%");
            })
            ->paginate(10);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    //create
    public function create()
    {
        $categories = DB::table('category')->get();
        return view('admin.ebooks.create', compact('categories'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:category,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'tumbnail' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf',
        ]);

        $tumbnail = null;
        if ($request->file('tumbnail')) {
            $tumbnail = $request->file('tumbnail')->store('tumbnails', 'public');
        }

        $file = $request->file('file')->store('files', 'public');

        EbooksModel::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'tumbnail' => $tumbnail,
            'description' => $request->description,
            'file' => $file,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook created successfully.');
    }

    //edit
    public function edit($id)
    {
        $ebook = EbooksModel::find($id);
        $categories = DB::table('category')->get();
        return view('admin.ebooks.edit', compact('ebook', 'categories'));
    }

    //update
    public function update(Request $request, $id)
    {
        $ebook = EbooksModel::find($id);

        $request->validate([
            'category_id' => 'required|exists:category,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'tumbnail' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf',
        ]);

        $tumbnail = $ebook->tumbnail;
        if ($request->file('tumbnail')) {
            if ($tumbnail) {
                Storage::disk('public')->delete($tumbnail);
            }
            $tumbnail = $request->file('tumbnail')->store('tumbnails', 'public');
        }

        $file = $ebook->file;
        if ($request->file('file')) {
            if ($file) {
                Storage::disk('public')->delete($file);
            }
            $file = $request->file('file')->store('files', 'public');
        }

        $ebook->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'tumbnail' => $tumbnail,
            'description' => $request->description,
            'file' => $file,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook updated successfully.');
    }

    //destroy
    public function destroy($id)
    {
        $ebook = EbooksModel::find($id);
        $ebook->delete();
        return redirect()->route('ebooks.index')->with('success', 'Ebook deleted successfully.');
    }
}
