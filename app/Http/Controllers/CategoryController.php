<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 200,
            'categories' => $categories    
        ],200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'img' => 'required|image|max:20480',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $imagePath = $request->file('img')->store('categories', 'public');

        $category = Category::create([
            'img' => $imagePath,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    public function show(Category $category)
    {
        return response()->json([
            'status' => 200,
            'category' => $category
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'img' => 'sometimes|image|max:20480',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('categories', 'public');
            $category->img = $imagePath;
        }

        if (isset($validatedData['name'])) {
            $category->name = $validatedData['name'];
        }

        if (isset($validatedData['description'])) {
            $category->description = $validatedData['description'];
        }

        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
            'category' => $category
        ], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
