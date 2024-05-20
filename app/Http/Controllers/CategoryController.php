<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $category = Category::paginate(10);
        $searchTerm = request('search');
        $orderBy = request('order_by', 'name');
        $sortDirection = request('sort_direction', 'asc');

        $categories = Category::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->orderBy($orderBy, $sortDirection)
            ->paginate(10);
        return response()->json(['data' => $categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|string|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $category = new Category();
        $category->name = $request->name;
        $category->image = $request->file('image')->store('categories');
        $category->save();
        return response()->json(['data' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'No data found by this id ' . $id], 404);
        }
        return response()->json(['data' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|string|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'No data found by this id ' . $id], 404);
        }
        // Update the category name
        $category->name = $request->name;
        $category->save();

        return response()->json(['message' => 'category updated successfully', 'data' => $category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'No data found by this id ' . $id], 404);
        }
        $category->delete();
        return response()->json(['message' => 'category deleted successfully'], 200);
    }
}
