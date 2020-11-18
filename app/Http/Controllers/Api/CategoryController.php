<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->category = $request->category;
        $category->description = $request->description;
        $category->save();
        return response()->json(['success' => 'New Category has been added!']);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->category = $request->category;
        $category->description = $request->description;
        $category->save();
        return response()->json(['success' => 'Category successfully Updated!']);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category successfully deleted!']);
    }
}
