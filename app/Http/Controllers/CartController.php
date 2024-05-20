<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->user_id = $user->id;
        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json(["data"=>$cart],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         //
         $cart = Cart::with('user')->find($id);
         if(!$cart){
             return response()->json(['message' => 'Cart not found'], 404);
         }
         return response()->json(['data' => $cart], 200);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cart = Cart::find($id);
        $cart->product_id = $request->product_id;
        $cart->user_id = $user->id;
        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json(["message"=>"cart updated successfully","data"=>$cart],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $cart = Cart::with('user')->find($id);

        if (!$cart) {
            return response()->json(['message' => 'No data found by this id ' . $id], 404);
        }
        $cart->delete();
        return response()->json(['message' => 'cart deleted successfully'], 200);
    }
}
