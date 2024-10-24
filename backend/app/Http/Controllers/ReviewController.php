<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movieId = $request->query('movie_id');
        if ($movieId) {
            $reviews = Review::with('user')->where('movie_id', $movieId)->get();
        } else {
            $reviews = Review::with('user')->get();
        }
    
        return response()->json($reviews);
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
        try {
            $validatedData = $request->validate([
                'review_text' => 'required|string|max:255',
                'movie_id' => 'required|integer',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $review = Review::create([
                'user_id' => Auth::id(),
                'movie_id' => $validatedData['movie_id'],
                'review_text' => $validatedData['review_text'],
                'rating' => $validatedData['rating'],
            ]);

            $reviewWithUser = Review::with('user')->find($review->id);

            return response()->json([
                'message' => 'Review saved successfully!',
                'review' => $reviewWithUser
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($movie_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'review_text' => 'required|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $review = Review::findOrFail($id);
            if ($review->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $review->update([
                'review_text' => $validatedData['review_text'],
                'rating' => $validatedData['rating'],
            ]);

            $updatedReviewWithUser = Review::with('user')->find($review->id);

            return response()->json([
                'message' => 'Review updated successfully!',
                'review' => $updatedReviewWithUser
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(["message" => "The review has been successfully deleted." ]);
    }
}
