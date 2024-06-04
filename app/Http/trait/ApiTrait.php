<?php

namespace App\Http\trait;

trait ApiTrait
{
    public function apiResponse($data,$token,$message,$status){
        $array = [
            'data'          => $data,
            'message'       => $message,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ];
        return response()->json($array,$status);
    }
    public function apiCostum($token,$status){
        $array = [
            
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ];
        return response()->json($array,$status);
    }
   public function customeResponse($message,$status)
   {
    return response()->json($message,$status);
   }
}
