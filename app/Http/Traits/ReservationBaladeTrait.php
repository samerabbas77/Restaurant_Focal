<?php
namespace App\Http\Traits;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\StoreReservationBlade;
use App\Http\Requests\UpdateReservationBlade;


trait ReservationBaladeTrait
{
    public function storeReservation(StoreReservationBlade $request)
    {
        Log::info('Incoming request', ['request' => $request->all()]);

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $openingTime = $startDate->copy()->setTime(8, 0, 0);
        $closingTime = $startDate->copy()->setTime(23, 59, 59);

        if ($startDate->lt($openingTime) || $endDate->gt($closingTime)) {
            Log::info('Reservation time is outside of operating hours', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'openingTime' => $openingTime,
                'closingTime' => $closingTime
            ]);
            return redirect()->route('reservation.index')->with('error', ':Reservation time must be within operating hours (8 AM to 12 AM)');
        }

        $tableId = $request->input('table_id');

        $existingReservation = $this->checkExistingReservation($startDate, $endDate, $tableId);

        if ($existingReservation) {
            return redirect()->route('reservation.index')->with('error', 'Table is already reserved for the given time period');
        }

        $reservationData = $request->all();
        $reservationData['status'] = 'checkedout';

        $reservation = Reservation::create($reservationData);
        Log::info('Reservation created successfully', ['reservation' => $reservation]);
        return true;


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


    public function updateReservation(UpdateReservationBlade $request, $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return redirect()->route('reservation.index')->with('error', 'Reservation not found');
        }



        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

            $openingTime = $startDate->copy()->setTime(8, 0, 0);
            $closingTime = $startDate->copy()->setTime(23, 59, 59);

            if ($startDate->lt($openingTime) || $endDate->gt($closingTime)) {
                return redirect()->route('reservation.index')->with('error', 'Reservation time must be within operating hours (8 AM to 12 AM)');
            }
            $existingReservation = $this->checkExistingReservationForUpdate($startDate, $endDate, $id, $reservation->table_id);
            if ($existingReservation) {
                return redirect()->route('reservation.index')->with('error', 'Table is already reserved for the given time period');
            }
        }

        $reservation->update($request->all());

        return true;

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

}
