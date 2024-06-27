<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TableResource;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\RenewReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public function showReservations()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $userId = $user->id;
        $reservations = Reservation::where('user_id', $userId)->get();
        return response()->json(ReservationResource::collection($reservations));
    }

    public function storeReservation(StoreReservationRequest $request)
    {


        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $openingTime = $startDate->copy()->setTime(8, 0, 0);
        $closingTime = $startDate->copy()->setTime(23, 59, 59);

        if ($startDate->lt($openingTime) || $endDate->gt($closingTime)) {
            return response()->json(['message' => 'Reservation time must be within operating hours (8 AM to 12 AM)'], 400);
        }

        $tableId = $request->input('table_id');

        $existingReservation = $this->checkExistingReservation($startDate, $endDate, $tableId);

        if ($existingReservation) {
            return response()->json([
                'message' => 'Table is already reserved for the given time period',
                'conflicting_reservation' => [
                    'start_date' => $existingReservation->start_date,
                    'end_date' => $existingReservation->end_date
                ]
            ], 409);
        }

        $reservationData = $request->all();
        $reservationData['status'] = 'checkedout';

        $reservation = Reservation::create($reservationData);
        return response()->json(new ReservationResource($reservation), 201);
    }

    protected function checkExistingReservation($startDate, $endDate, $tableId)
    {
        return Reservation::where('table_id', $tableId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->first();
    }

    public function updateReservation(UpdateReservationRequest $request, $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($reservation->user_id !== Auth::user()->id) {
            return response()->json(['message' => 'this reservation does not belong to you'], 400);
        }

        if ($reservation->status !== 'checkedout') {
            return response()->json(['message' => 'Reservation can only be updated if status is checked_out'], 400);
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

            $openingTime = $startDate->copy()->setTime(8, 0, 0);
            $closingTime = $startDate->copy()->setTime(23, 59, 59);

            if ($startDate->lt($openingTime) || $endDate->gt($closingTime)) {
                return response()->json(['message' => 'Reservation time must be within operating hours (8 AM to 12 AM)'], 400);
            }

            $existingReservation = $this->checkExistingReservationForUpdate($startDate, $endDate, $id, $reservation->table_id);

            if ($existingReservation) {
                return response()->json([
                    'message' => 'Table is already reserved for the given time period',
                    'conflicting_reservation' => [
                        'start_date' => $existingReservation->start_date,
                        'end_date' => $existingReservation->end_date
                    ]
                ], 409);
            }
        }

        $reservation->update($request->all());
        return response()->json(new ReservationResource($reservation));
    }

    protected function checkExistingReservationForUpdate($startDate, $endDate, $id, $tableId)
    {
        return Reservation::where('table_id', $tableId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->where('id', '!=', $id)
            ->first();
    }

    public function deleteReservation($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($reservation->user_id !== Auth::user()->id) {
            return response()->json(['message' => 'this reservation does not belong to you'], 400);
        }

        if ($reservation->status !== 'checkedout') {
            return response()->json(['message' => 'Reservation can only be deleted if status is checked_out'], 400);
        }

        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully'], 200);
    }

    public function renewReservation(RenewReservationRequest $request, $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($reservation->user_id !== Auth::user()->id) {
            return response()->json(['message' => 'this reservation does not belong to you'], 400);
        }

        if ($reservation->status !== 'checkedin') {
            return response()->json(['message' => 'Reservation can only be renewed if status is checked_In'], 400);
        }

        $newStartDate = Carbon::parse($request->input('new_start_date'));
        $newEndDate = Carbon::parse($request->input('new_end_date'));

        $openingTime = $newStartDate->copy()->setTime(8, 0, 0);
        $closingTime = $newStartDate->copy()->setTime(23, 59, 59);

        if ($newStartDate->lt($openingTime) || $newEndDate->gt($closingTime)) {
            return response()->json(['message' => 'Reservation time must be within operating hours (8 AM to 12 AM)'], 400);
        }

        $existingReservation = $this->checkExistingReservationForUpdate($newStartDate, $newEndDate, $id, $reservation->table_id);

        if ($existingReservation) {
            $alternativeTables = Table::where('chair_number', '>=', $reservation->table->chair_number)
                ->whereDoesntHave('reservations', function ($query) use ($newStartDate, $newEndDate) {
                    $query->whereBetween('start_date', [$newStartDate, $newEndDate])
                        ->orWhereBetween('end_date', [$newStartDate, $newEndDate])
                        ->orWhere(function ($query) use ($newStartDate, $newEndDate) {
                            $query->where('start_date', '<', $newStartDate)
                                ->where('end_date', '>', $newEndDate);
                        });
                })
                ->get();

            return response()->json([
                'message' => 'The requested table is already reserved at the new time. Here are alternative tables.',
                'alternative_tables' => TableResource::collection($alternativeTables)
            ], 409);
        }

        $reservation->end_date = $newEndDate;
        $reservation->status = 'checkedin';
        $reservation->save();

        return response()->json(['message' => 'Reservation renewed successfully', new ReservationResource($reservation)], 200);
    }
}
