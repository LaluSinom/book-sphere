<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekening;

class RekeningController extends Controller
{
    //index
    public function index()
    {
        $rekening = Rekening::paginate(10);
        return view('admin.rekening.index', compact('rekening'));
    }

    //create
    public function create()
    {
        return view('admin.rekening.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'nomor_rekening' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:255',
            'logo_bank' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $logo_bank = null;
        if ($request->file('logo_bank')) {
            $logo_bank = $request->file('logo_bank')->store('logo_bank', 'public');
        }

        Rekening::create([
            'nomor_rekening' => $request->nomor_rekening,
            'nama_bank' => $request->nama_bank,
            'logo_bank' => $logo_bank,
        ]);

        return redirect()->route('rekening.index')->with('success', 'Rekening created successfully.');
    }

    //destroy
    public function destroy($id)
    {
        $rekening=Rekening::find($id);
        $rekening->delete();
        return redirect()->route('rekening.index')->with('success', 'Rekening deleted successfully.');
    }
}
