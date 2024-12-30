<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokLog;
use Illuminate\Http\Request;

class StokLogController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $barang->increment('quantity', $request->quantity);

        StokLog::create([
            'barang_id' => $request->barang_id,
            'quantity' => $request->quantity,
            'type' => 'add',
            'description' => $request->description,
        ]);

        return redirect()->route('barang.index')->with('success', 'Quantity added successfully.');
    }

    public function subtract(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        if ($barang->quantity < $request->quantity) {
            return redirect()->route('barang.index')->with('error', 'Not enough stock.');
        }

        $barang->decrement('quantity', $request->quantity);

        StokLog::create([
            'barang_id' => $request->barang_id,
            'quantity' => $request->quantity,
            'type' => 'subtract',
            'description' => $request->description,
        ]);

        return redirect()->route('barang.index')->with('success', 'Quantity subtracted successfully.');
    }
}
