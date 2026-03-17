<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    // ১. ইউজার শুধুমাত্র নিজের তৈরি করা সব লিঙ্ক দেখতে পাবেন (Pagination সহ)
    public function index()
    {
        $urls = Auth::user()->shortenedUrls()->paginate(10);
        return response()->json($urls);
    }

    // ২. নতুন শর্ট লিঙ্ক তৈরি করা
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
            'expires_at' => 'nullable|date_format:Y-m-d|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $expiryDate = $request->expires_at ?? now()->addWeek();

        $url = ShortenedUrl::create([
            'user_id' => Auth::id(),
            'original_url' => $request->original_url,
            'short_code' => Str::random(6), // ৬ অক্ষরের র্যান্ডম কোড
            'expires_at' => $expiryDate,
        ]);

        return response()->json($url, 201);
    }

    // ৩. নির্দিষ্ট একটি লিঙ্কের ডিটেইলস দেখা
    public function show($id)
    {
        // $url = ShortenedUrl::where('user_id', Auth::id())->findOrFail($id);
        $url = ShortenedUrl::findOrFail($id);
        $this->authorize('view', $url);
        return response()->json($url);
    }

    // ৪. লিঙ্ক আপডেট করা (যেমন: আসল ইউআরএল বা মেয়াদ পরিবর্তন)
    public function update(Request $request, $id)
    {
        // $url = ShortenedUrl::where('user_id', Auth::id())->findOrFail($id);
        $url = ShortenedUrl::findOrFail($id);
        $this->authorize('update', $url);
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'original_url' => 'sometimes|url',
            'expires_at' => 'nullable|date_format:Y-m-d|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $url->update($request->only(['original_url', 'expires_at']));

        return response()->json($url);
    }

    // ৫. লিঙ্ক ডিলিট করা
    public function destroy($id)
    {
        // $url = ShortenedUrl::where('user_id', Auth::id())->findOrFail($id);
        $url = ShortenedUrl::findOrFail($id);
        $this->authorize('delete', $url);
        $url->delete();

        return response()->json(null, 204);
    }

    public function redirect($code)
    {
        $url = ShortenedUrl::where('short_code', $code)->first();

        if (!$url) {
            return response()->json([
                'message' => 'URL not found'
            ], 404);
        }

        if ($url->expires_at < now()) {
            return response()->json([
                'message' => 'URL has expired'
            ], 410);
        }

        $url->increment('clicks');

        return redirect($url->original_url);
    }
}