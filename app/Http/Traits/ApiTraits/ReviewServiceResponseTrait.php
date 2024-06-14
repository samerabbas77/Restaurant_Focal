<?php 

namespace App\Http\Traits\ApiTraits;

trait ReviewServiceResponseTrait 
{
    public function reviewResponse($data,$message,$status){
        $array = [
            'data'=>$data,
            'message'=>$message,
        ];

        return response()->json($array,$status);
    }
    public function apiDelete($message,$status){
        return response()->json($message,$status);
    }  
    public function apiResponse($message,$status){
        return response()->json($message,$status);
    }  
}