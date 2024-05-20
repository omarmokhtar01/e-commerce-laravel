<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // to get order related to this user
        $orders= Order::with('user')->paginate(10);
        return response()->json(['data' => $orders], 200);

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
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve cart items for the user
        $cartItems = Cart::where('user_id', $user->id)->get();

        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Create orders from cart items
        foreach ($cartItems as $cartItem) {
            Order::create([
                'user_id' => $user->id,
                'total_price' => $cartItem->price * $cartItem->quantity,
                'payment_method' => $request->payment_method,
                'location_id' => $user->location_id,
                'status' => 'pending',
                // You might want to add other fields like product_id, quantity, etc. depending on your requirements
            ]);
        }

        // Clear the cart after creating orders
        Cart::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Orders created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the order with the given ID
        $order = Order::with('user')->find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Check if the authenticated user is the owner of the order
        if (Auth::id() !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $order], 200);
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
        // Find the order with the given ID
        $order = Order::find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Check if the authenticated user is the owner of the order
        if (Auth::id() !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'total_price' => 'numeric',
            'payment_method' => 'in:cash,visa',
            'location_id' => 'exists:locations,id'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update the order
        $order->update($request->only(['total_price', 'payment_method', 'location_id', 'status']));

        return response()->json(['data' => $order], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the order with the given ID
        $order = Order::find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Check if the authenticated user is the owner of the order
        if (Auth::id() !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete the order
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}