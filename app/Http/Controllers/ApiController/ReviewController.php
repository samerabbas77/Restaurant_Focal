<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Review;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReviewRequest;

use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewServiceResource;
use App\Http\Resources\ReviewShowResource;
use App\Http\Traits\ApiTraits\ReviewServiceResponseTrait;

class ReviewController extends Controller
{
    use ReviewServiceResponseTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        try{
           $reviews=ReviewServiceResource::collection(Review::all());
           return $this->reviewResponse($reviews,'index successfully',200);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you want to see all review',400);
        }   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        try{
            $request->validated();
            $user_id = auth()->user()->id;
    
            $review = Review::create([
                'service_rating' => $request->service_rating,
                'user_id' => $user_id,
                'comments' => $request->comments,
            ]);
        
            $review->save();
            return $this->reviewResponse(new ReviewServiceResource($review),'you add review successfully',201);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you add review,sorry',400);
        }       
    }
    public function show()
    {
        try{
             $user = Auth::user();
             $review = Review::where('user_id', $user->id)->get();
             $reviewResourse=ReviewShowResource::collection($review);
             return  $this->reviewResponse($reviewResourse,'this is your request',200);
        }catch(\Exception $th){
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you show review,sorry',400);
        }   
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        try{
           $request->validated();
        
           if ($review->user_id !== auth()->user()->id) {
              return $this->apiResponse( 'You can not edit ,because this review is not yours',400);
           }
           else{
               $review->service_rating=$request->service_rating??$review->service_rating;
               $review->comments=$request->comments??$review->comments;
               $review->save();
               return $this->reviewResponse(new ReviewServiceResource($review),'you updated review successfully',201);
           }
        }catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you update review,sorry',400);
        }   
    }       
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        try{
           if ($review->user_id !== auth()->user()->id) {
             return $this->apiResponse('You can not delete ,because this review is not yours',400);
           }
           else{
              $review->delete();
              $review = Review::withTrashed()->findOrFail($review->id);
              $review->forceDelete();
              return $this->apiDelete('you deleted successfully',200);
           }
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you delete review,sorry',400);
        }     
    }
}
