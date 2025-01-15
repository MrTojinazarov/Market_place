<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImagesController extends Controller
{
    public function index()
    {
        $images = ProductImage::with('product_variant')->get();
        $variants = ProductVariant::all();

        return view('admin.product_image', compact('images', 'variants'));
    }

    public function create(Request $request)
    {

        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'image_url' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_main' => 'nullable',
        ]);

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $path = 'images/' . $imageName;
        }

        $isMain = $request->has('is_main') ? 1 : 0;
        ProductImage::create([
            'product_variant_id' => $request->product_variant_id,
            'image_url' => $path,
            'is_main' => $isMain,
        ]);

        return redirect()->back()->with('success', 'Image created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_main' => 'nullable',
        ]);
    
        $productImage = ProductImage::findOrFail($id);
    
        if ($request->hasFile('image_url')) {
            if (file_exists(public_path($productImage->image_url))) {
                unlink(public_path($productImage->image_url));
            }
    
            $image = $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
    
            $image->move(public_path('images'), $imageName);
    
            $path = 'images/' . $imageName;
        } else {
            $path = $request->input('old_img');
        }
    
        $isMain = $request->has('is_main') ? 1 : 0;
    
        $productImage->product_variant_id = $request->product_variant_id;
        $productImage->image_url = $path;
        $productImage->is_main = $isMain;
    
        $productImage->save();
    
        return redirect()->back()->with('success', 'Image updated successfully.');
    }
    

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        Storage::disk('public')->delete($image->image_url);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}
