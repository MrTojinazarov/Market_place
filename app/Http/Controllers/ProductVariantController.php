<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $productVariants = ProductVariant::with('product')->get();
        $products = Product::all();
        return view('admin.product_variant', compact('productVariants', 'products'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'attribute_name' => 'nullable|string|max:255',
            'attribute_value' => 'required|string|max:255',
            'price_difference' => 'nullable|numeric',
        ]);
        $product = Product::findOrFail($request->product_id);
        ProductVariant::create([
            'product_id' => $request->product_id,
            'attribute_name' => $product->name . " " . $request->attribute_name,
            'attribute_value' => $request->attribute_value,
            'price_difference' => $request->price_difference,
        ]);

        return redirect()->route('product_variant.index')->with('success', 'Product Variant created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'attribute_name' => 'nullable|string|max:255',
            'attribute_value' => 'required|string|max:255',
            'price_difference' => 'nullable|numeric',
        ]);

        $variant = ProductVariant::findOrFail($id);
        $variant->update($request->all());

        return redirect()->route('product_variant.index')->with('success', 'Product Variant updated successfully!');
    }

    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return redirect()->route('product_variant.index')->with('success', 'Product Variant deleted successfully!');
    }
}
