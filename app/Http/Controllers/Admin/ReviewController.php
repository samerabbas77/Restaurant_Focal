<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:إدارة التقييمات|التقييمات'])->only('index');
        $this->middleware(['permission:حذف تقييم'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة تقييم'])->only('restore');
    }

//========================================================================================================================

    public function index()
    {
        try {
            $reviews = Review::all();
            $trachedReviews = Review::onlyTrashed()->get();
            return view('Admin.reviews', compact('reviews', 'trachedReviews'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }

    }

//========================================================================================================================
    public function destroy(Review $review)
    {
        try {
            $review->delete();
            session()->flash('delete', 'delete succsesfuly');
            return redirect()->route('reviews.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

//========================================================================================================================
    public function restore($id)
    {
        try {
            $review = Review::withTrashed()->findOrFail($id);
            $review->restore();

            return redirect()->route('reviews.index')->with('edit', 'Review restored successfully.');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to delete Review: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function forceDelete($id)
    {
        try {
            $review = Review::withTrashed()->findOrFail($id);
            $review->forceDelete();

            return redirect()->route('reviews.index')->with('delete', 'Review permanently deleted.');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to delete Review: ' . $th->getMessage());
        }
    }
    
//========================================================================================================================

}
