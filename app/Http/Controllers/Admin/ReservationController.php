<?php

namespace App\Http\Controllers\Admin;
use Exception;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\Reservation_updateRequest;


class ReservationController extends Controller
{
    public function index()
    {
        try{
            $reservations = Reservation::all();
            //dd($reservations);
            $users = User::all();
            $tables = Table::all();

            $trashedReservations = Reservation::onlyTrashed()->get();
            return view('Admin.reservation',compact('reservations' , 'users' , 'tables','trashedReservations'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function store(ReservationRequest $request)
    {

        try{
           $request->validated();

           $reservation = new Reservation();
           $reservation->user_id = $request->user_id;
           $reservation->table_id = $request->table_id;
           $reservation->start_date = $request->start_date;
           $reservation->end_date = $request->end_date;
           $reservation->save();

           session()->flash('Add','Add Susseccfully');
           return redirect()->route('reservation.store');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function update(Reservation_updateRequest $request, Reservation $reservation)
    {

        try{
           $request->validated();

           $reservation->user_id = $request->user_id;
           $reservation->table_id = $request->table_id;
           $reservation->start_date = $request->start_date;
           $reservation->end_date = $request->end_date;
           $reservation->save();

           session()->flash('edit','ُEdit Susseccfully');
           return redirect()->route('reservation.index');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function destroy(Reservation $reservation)
    {
        try{
           $reservation->delete();

           session()->flash('delete','Delete Susseccfully');
           return redirect()->route('reservation.index') ;
        }catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }
//========================================================================================================================

    public function restore($id)
    {
        try {
        $reservation = Reservation::withTrashed()->findOrFail($id);
        $reservation->restore();

        return redirect()->route('reservation.index')->with('edit', 'reservation restored successfully');}
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {   try {
        $reservation = Reservation::withTrashed()->findOrFail($id);
        $reservation->forceDelete();

        return redirect()->route('reservation.index')->with('delete', 'reservation permanently deleted');}
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

}
