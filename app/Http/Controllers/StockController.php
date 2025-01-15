<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('variant')->get();
        $product_variants = ProductVariant::all();
        return view('admin.stock', compact('stocks', 'product_variants'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Stock::create([
            'product_variant_id' => $request->product_variant_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('stock.index')->with('success', 'Stock added successfully!');
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $stock->update([
            'product_variant_id' => $request->product_variant_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('stock.index')->with('success', 'Stock updated successfully!');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stock.index')->with('success', 'Stock deleted successfully!');
    }
}
