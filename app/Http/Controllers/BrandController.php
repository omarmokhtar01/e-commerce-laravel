<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $brand = Brand::paginate(10);
        $searchTerm = request('search');
$orderBy = request('filter', 'name');
$sortDirection = request('sort', 'asc');

$brands = Brand::query()
    ->when($searchTerm, function ($query, $searchTerm) {
        $query->where('name','like', "%$searchTerm%");
    })
    ->orderBy($orderBy, $sortDirection)
    ->paginate(10);
        return response()->json(['data' => $brands], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       
        $validator = Validator::make($request->all(), [

                    'name' => 'required|min:6|string|unique:brands,name',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->image = $request->file('image')->store('brands');
            $brand->save();
            return response()->json(['data' => $brand], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'No data found by this id ' . $id], 404);
        }
        return response()->json(['data' => $brand], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
       
        $validator = Validator::make($request->all(), [

                    'name' => 'required|min:6|string|unique:brands,name'
                ]
            );
            $brand = Brand::find($id);
            if (!$brand) {
                return response()->json(['message' => 'No data found by this id ' . $id], 404);
            }
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            // Update the brand name
            $brand->name = $request->name;
            $brand->save();

            return response()->json(['message' => 'Brand updated successfully', 'data' => $brand], 200);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'No data found by this id ' . $id], 404);
        }
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }
}
