<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryB;

class CategoryBController extends Controller
{
    //index
    public function index()
    {
        $category = CategoryB::paginate(10);
        return view('admin.categoryBook.index', compact('category'));
    }

    //create

    public function create()
    {
        return view('admin.categoryBook.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CategoryB::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categoriesBook.index')->with('success', 'Category created successfully.');
    }

    //destroy
    public function destroy($id)
    {
        $category=CategoryB::find($id);
        $category->delete();
        return redirect()->route('categoriesBook.index')->with('success', 'Category Book deleted successfully.');
    }
}
