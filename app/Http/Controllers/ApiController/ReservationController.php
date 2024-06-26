<?php

namespace App\Http\Controllers\ApiController;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
// use App\Http\Traits\ApiTraits\ReservationTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\RenewReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Services\ReservationService;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{


    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    // Show Reservations
    public function show(): JsonResponse
    {
        try {
            return $this->reservationService->showReservations();
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching reservations'], 500);
        }
    }

    // Store the reservation
    public function store(StoreReservationRequest $request): JsonResponse
    {
        try {
            return $this->reservationService->storeReservation($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while storing the reservation: ' . $e->getMessage()], 500);
        }
    }

    // Update the reservation
    public function update(UpdateReservationRequest $request, $id): JsonResponse
    {
        try {
            return $this->reservationService->updateReservation($request, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the reservation'], 500);
        }
    }

    // Delete Reservation
    public function destroy($id): JsonResponse
    {
        try {
            return $this->reservationService->deleteReservation($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the reservation'], 500);
        }
    }

    // Renew the reservation
    public function renew(RenewReservationRequest $request, $id): JsonResponse
    {

        try {
            return $this->reservationService->renewReservation($request, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while renewing the reservation'], 500);
        }
    }

}
