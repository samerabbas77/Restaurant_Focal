<?php

namespace App\Http\Controllers\ApiController;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Traits\ReservationTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\RenewReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    use ReservationTrait;

    public function __construct()
    {
       
    }
// Show all cureent user Reservation========================================================================
    public function show($id)
    {
        try {
            return $this->showReservations($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching reservations'], 500);
        }
    }
// Store the reservation========================================================================
    public function store(StoreReservationRequest $request)
    {
        try {
            return $this->storeReservation($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while storing the reservation'], 500);
        }
    }
//update The reservation========================================================================
    public function update(UpdateReservationRequest $request, $id)
    {
        try {
            return $this->updateReservation($request, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the reservation'], 500);
        }
    }
//===Delete Reservation=====================================================================================
    public function destroy($id)
    {
        try {
            return $this->deleteReservation($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the reservation'], 500);
        }
    }
//Renew the reservation========================================================================
    public function renew(RenewReservationRequest $request, $id)
    {
        try {
            return $this->renewReservation($request, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while renewing the reservation'], 500);
        }
    }

//Show user Reservation History ========================================================================
   public function userReservation()
   {
       $userReservation = reservation::where('user_id',Auth::id())
                                       ->whereNotNull('deleted_at')
                                       ->get();
       return $this->successResponse(ReservationResource::collection( $userReservation),"User Reservation History send successfully");

   }
   
}
