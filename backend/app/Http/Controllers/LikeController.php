<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LikeController extends Controller
{

    public function index() {
        $api_key = config('services.tmdb.api_key');
        $user = Auth::user();
        $likes = $user->likes;

        foreach($likes as $like) {
            $tmdb_api_key = "http://api.themoviedb.org/3/movie/" . $like->movie_id . "?api_key=" . $api_key;
            $response = Http::get($tmdb_api_key);
            if($response->successful()) {
                $details[] = $response->json();
            }
        }

        return response()->json($details);
    }


    public function toggleLike(Request $request) {
        $validatedData = $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $like = Like::where('user_id', Auth::id())
        ->where('movie_id', $validatedData['movie_id'])
        ->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Like::create([
                'movie_id' => $validatedData['movie_id'],
                'user_id' => Auth::id(),
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function checkLikeStatus(Request $request) {
        $validatedData = $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $isLike = Like::where('user_id', Auth::id())
        ->where('movie_id', $validatedData['movie_id'])
        ->exists();

        return response()->json($isLike);
    }

    
}
