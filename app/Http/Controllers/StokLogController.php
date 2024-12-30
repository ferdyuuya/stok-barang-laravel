<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokLog;
use Illuminate\Http\Request;

class StokLogController extends Controller
{
    public function add(Request $request)
    {
        // Validate the request
        $request->validate([
            'barang_id' => 'required|exists:barangs,id', // Ensures the barang exists
            'quantity' => 'required|integer|min:1', // Quantity must be an integer and at least 1
            'description' => 'nullable|string', // Optional description
        ]);

        // dd($request);

        // Find the Barang record
        $barang = Barang::findOrFail($request->barang_id);

        // Ensure the quantity is initialized, if it's nullable and has a null value
        if (is_null($barang->quantity)) {
            $barang->quantity = 0;
        }

        // Increment the quantity
        $barang->increment('quantity', $request->quantity);

        // Log the stock change
        StokLog::create([
            'barang_id' => $request->barang_id,
            'quantity' => $request->quantity,
            'action' => 'added', // Fixed the action value to 'add'
            'description' => $request->description,
        ]);

        // Redirect back to the barang index page with a success message
        return redirect()->route('barang.index')->with('success', 'Quantity added successfully.');
    }


    public function subtract(Request $request)
    {
        // Validate the request
        $request->validate([
            'barang_id' => 'required|exists:barangs,id', // Ensures the barang exists
            'quantity' => 'required|integer|min:1', // Quantity must be an integer and at least 1
            'description' => 'nullable|string', // Optional description
        ]);

        // dd($request);

        // Find the Barang record
        $barang = Barang::findOrFail($request->barang_id);

        // Ensure the quantity is initialized, if it's nullable and has a null value
        if (is_null($barang->quantity)) {
            $barang->quantity = 0;
        }

        // Increment the quantity
        $barang->decrement('quantity', $request->quantity);

        // Log the stock change
        StokLog::create([
            'barang_id' => $request->barang_id,
            'quantity' => $request->quantity,
            'action' => 'subtracted', // Fixed the action value to 'subtracted'
            'description' => $request->description,
        ]);

        // Redirect back to the barang index page with a success message
        return redirect()->route('barang.index')->with('success', 'Quantity subtracted successfully.');
    }
}
