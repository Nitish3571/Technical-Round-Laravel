<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){

        return view('pages.product.product-list');
    }

    public function show(){

        $products = Product::with('category')->get();
        return response()->json(['products' => $products]);
    }

    public function store(Request $request){

        try {
            $validatedData = $request->validate([
                'productImg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'productName' => 'required|string|max:255',
                'price' => 'required',
                'category_id' => 'required|integer|exists:categories,id',
                'status' => 'required|boolean',
            ]);

            if ($request->hasFile('productImg')) {
                $file = $request->file('productImg');
                $fileName = time().'_'.$file->getClientOriginalName();
                $destinationPath = public_path('img/products');
                $file->move($destinationPath, $fileName);
                $validatedData['productImg'] = $fileName;
            }

            $product = new Product();
            $product->productImg = $validatedData['productImg'] ?? null;
            $product->name = $validatedData['productName'];
            $product->price = $validatedData['price'];
            $product->category_id = $validatedData['category_id'];
            $product->status = $validatedData['status'];
            $product->save();

            return response()->json(['message' => 'Product added successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error']);
        }

    }

    public function edit($id){

        Log::info($id);
        $product = Product::with('category')->find($id);
        if (!$product) {
            abort(404);
        }
        return response()->json(['product' => $product]);
    }

    public function update(Request $request, $id){

        Log::info($request);
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['status' => 404, 'message' => 'Product not found']);
            }

            $validatedData = $request->validate([
                'productName' => 'required|string|max:255',
                'price' => 'required',
                'category_id' => 'required|integer|exists:categories,id',
                'status' => 'required|boolean',
            ]);


            if ($request->hasFile('productImg')) {
                if ($product->productImg) {
                    $destinationPath = public_path('img/products');
                    $imagePath = $destinationPath . '/' . $product->productImg;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $file = $request->file('productImg');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('img/products');
                $file->move($destinationPath, $fileName);
                $product->productImg = $fileName;

            }

            $product->name = $validatedData['productName'];
            $product->price = $validatedData['price'];
            $product->category_id = $validatedData['category_id'];
            $product->status = $validatedData['status'];
            $product->save();

            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error']);
        }
    }

    public function delete($id){

        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
