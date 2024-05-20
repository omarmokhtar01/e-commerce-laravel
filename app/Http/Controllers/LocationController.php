<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'city' => 'required|min:3|string',
            'street' => 'required|min:3|string',
            'building' => 'required|min:3|string',
        ]);
        $existingLocation = Location::where('user_id', Auth::id())->first();
        $user = Auth::user();
        if ($existingLocation) {
            // $locationData = $existingLocation;
            // $locationData['user'] = $user;
            return response()->json(
                [
                    'message' => 'Location already exists for the user',
                    // 'location' => $locationData
                ],
                409
            );
        }

        $location = Location::create([
            'city' => $request->city,
            'street' => $request->street,
            'building' => $request->building,
            'user_id' => Auth::id()
        ]);


        $locationData = $location;
        $locationData['user'] = $user;

        return response()->json(['message' => 'Location added successfully', 'location' => $locationData], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $location = Location::find($id);
        $user = Auth::user();
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        $request->validate([
            'city' => 'required',
            'street' => 'required',
            'building' => 'required'
        ]);
        if ($user->id !== $location->user_id) {
            return response()->json(['message' => 'You are not authorized to delete this location'], 403);
        }
        $location->city = $request->city;
        $location->street = $request->street;
        $location->building = $request->building;
        $location->save();
        $location['user'] = $user;
        return response()->json(['message' => 'Location updated successfully', 'location' => $location], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $location = Location::find($id);
        $user = Auth::id();
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        if ($user !== $location->user_id) {
            return response()->json(['message' => 'You are not authorized to delete this location'], 403);
        }
        $location->delete();
        return response()->json(['message' => 'Location deleted successfully'], 200);
    }
}
