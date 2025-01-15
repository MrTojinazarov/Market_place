<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Stock;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
    
        return view('client.index', compact('categories'));
    }

    public function items($id)
    {
        $categories = Category::with('products')->get();
        $products = Product::where('category_id', $id)->with('variants')->get();
   

        return view('client.product', compact('categories', 'products'));
    }

    public function variants($id)
    {
        $categories = Category::with('products')->get();
        $product_variants = ProductVariant::where('product_id', $id)->with('stock', 'images')->get();
        $product = Product::findOrFail($id);
        // dd($product);

        foreach ($product_variants as $product_variant) {
            $product_variant->price_difference = $product->base_price + $product_variant->price_difference;
        }

        return view('client.product_variant', compact('categories', 'product_variants'));

    }

    public function back()
    {
        return redirect()->route('client.index');
    }

}
