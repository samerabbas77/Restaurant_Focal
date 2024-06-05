<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        try{ $reviews = Review::all();
        return view('Admin.reviews', compact('reviews'));}
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }

    }

//========================================================================================================================
    public function destroy(Review $review)
    {
        try {
            $review->delete();
            session()->flash('delete','delete succsesfuly');
            return redirect()->route('reviews.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

//========================================================================================================================

}
