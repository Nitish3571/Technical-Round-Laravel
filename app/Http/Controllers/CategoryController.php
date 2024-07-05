<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('pages/category/category-list' , compact('categories'));
    }

    public function show(){
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => 'Category added successfully']);

    }
    public function edit($id){

        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request){

            $category = Category::findOrFail($request->id);
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();

            return response()->json(['message' => 'Category updated successfully']);
    }
    public function delete($id){

        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
