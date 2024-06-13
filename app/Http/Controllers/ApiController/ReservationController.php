<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Requests\RenewReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Resources\ReservationResource;
use App\Traits\ReservationTrait;

class ReservationController extends Controller
{
    use ReservationTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function show($id)
    {
        try {
            return $this->showReservations($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching reservations'], 500);
        }
    }

    public function store(StoreReservationRequest $request)
    {
        try {
            return $this->storeReservation($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while storing the reservation'], 500);
        }
    }

    public function update(UpdateReservationRequest $request, $id)
    {
        try {
            return $this->updateReservation($request, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the reservation'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            return $this->deleteReservation($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the reservation'], 500);
        }
    }

    public function renew(RenewReservationRequest $request, $id)
    {
        try {
            return $this->renewReservation($request, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while renewing the reservation'], 500);
        }
    }
}
