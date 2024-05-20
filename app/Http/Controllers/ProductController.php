<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $products = Product::paginate(10);
       

        $searchTerm = request('search');
        $orderBy = request('filter', 'name'); // Changed 'order_by' to 'filter' with default value 'name'
        $sortDirection = request('sort', 'asc'); // Changed 'sort_direction' to 'sort' with default value 'asc'
        
        $products = Product::query()
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%")
                    ->orWhere('description', 'like', "%$searchTerm%");
            })
            ->when(request('category_id'), function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when(request('brand_id'), function ($query, $brandId) {
                $query->where('brand_id', $brandId);
            })
            ->orderBy($orderBy, $sortDirection)
            ->paginate(10);
        
        
        return response()->json(["data"=>$products],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       
        $validator = Validator::make($request->all(), [

                'name' => 'required|min:6|string|unique:products,name',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'quantity' => 'required|integer|min:1',
                'discount' => 'nullable|numeric|min:0|max:100',
                'amount' => 'required|numeric|min:0',
                'is_avaliable' => 'required|boolean',
                'is_trendy' => 'required|boolean',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $product = new Product();
            $product->name = $request->name;
            $product->image = $request->file('image')->store('products');
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->quantity = $request->quantity;
            $product->discount = $request->discount;
            $product->amount = $request->amount;
            $product->is_avaliable = $request->is_avaliable;
            $product->is_trendy = $request->is_trendy;
            $product->save();
            
            return response()->json(["data"=>$product],200);

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
