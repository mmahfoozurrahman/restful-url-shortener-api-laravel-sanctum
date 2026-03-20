<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // ১. নিজের প্রোফাইল দেখা (View Profile)
    public function show()
    {
        //dd('inside show method');
        return response()->json(Auth::user());
    }

    // ২. প্রোফাইল আপডেট করা (Update Profile)
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only('name', 'email'));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // ৩. অ্যাকাউন্ট ডিলিট করা (Delete Account)
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // যেহেতু আমরা মাইগ্রেশনে onDelete('cascade') দিয়েছি, 
        // ইউজার ডিলিট হলে তার সব শর্ট লিঙ্কও অটোমেটিক ডিলিট হয়ে যাবে।
        $user->delete();

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Account and all associated URLs deleted successfully'
        ], 200);
    }
}
