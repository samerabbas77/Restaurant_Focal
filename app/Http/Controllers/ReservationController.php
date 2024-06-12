<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReservationResource;

class ReservationController extends Controller
{
   //======Show user Reservation History ========================================================================
   public function userReservation()
   {
       $userReservation = reservation::where('user_id',Auth::id())
                                       ->whereNotNull('deleted_at')
                                       ->get();
       return $this->successResponse(ReservationResource::collection( $userReservation),"User Reservation History send successfully");

   }
//Delete Reservation=====================================================================================

   public function delete_reservation(reservation $reservation)
   {

   }
}
