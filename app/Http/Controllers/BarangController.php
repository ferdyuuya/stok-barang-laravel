<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokLog;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::paginate(10); 
        return view('barang.index', compact('barangs'));
    }

    public function show($barang_id)
    {
        $barang = Barang::find($barang_id);
        $stokLogs = StokLog::where('barang_id', $barang_id)->paginate(10);

        return view('barang.show', compact('barang', 'stokLogs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    

    public function store(Request $request)
    {   
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);   
        Barang::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'quantity' => 0,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang created successfully.');
    }

    public function edit($barang_id)
    {
        $barang = Barang::find($barang_id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $barang_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $barang = Barang::find($barang_id);
        $barang->name = $validatedData['name'];
        $barang->description = $validatedData['description'];
        $barang->save();

        return redirect()->route('barang.show', ['barang' => $barang_id])->with('success', 'Barang updated successfully.');
    }

    public function destroy($barang_id)
    {
        $barang = Barang::find($barang_id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang deleted successfully.');
    }

    


}
