<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Traits\ReservationBaladeTrait;
use App\Http\Requests\StoreReservationBlade;
use App\Http\Requests\UpdateReservationBlade;



class ReservationController extends Controller
{
    use ReservationBaladeTrait;

    public function __construct()
    {

        $this->middleware(['permission:ادارة الحجوزات|الحجوزات'])->only('index');
        $this->middleware(['permission:اضافة حجز'])->only('store');
        $this->middleware(['permission:تعديل حجز'])->only('update');
        $this->middleware(['permission:حذف حجز'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة حجز'])->only('restore');
    }

//========================================================================================================================

    public function index()
    {
        try {
            $reservations = Reservation::all();
            $users = User::all();
            $tables = Table::all();
           
            $trashedReservations = Reservation::onlyTrashed()->get();
            return view('Admin.reservation', compact('reservations', 'users', 'tables', 'trashedReservations'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function store(StoreReservationBlade $request)
    {
    try {      
        $result = $this->storeReservation($request); 
            if ($result instanceof \Illuminate\Http\RedirectResponse) {
                return redirect()->route('reservation.index'); // Handle the redirect
            }        
             return redirect()->route('reservation.index')->with('Add', 'Add Susseccfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function update( UpdateReservationBlade $request, Reservation $reservation)
    {

        try {
            $result = $this->updateReservation($request, $reservation->id);
            if ($result instanceof \Illuminate\Http\RedirectResponse) 
            {
                return redirect()->route('reservation.index'); // Handle the redirect
            } 
            return redirect()->route('reservation.index')->with('edit', 'ُEdit Susseccfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();

            session()->flash('delete', 'Delete Susseccfully');
            return redirect()->route('reservation.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function restore($id)
    {
        try {
            $reservation = Reservation::withTrashed()->findOrFail($id);
            $reservation->restore();


            return redirect()->route('reservation.index')->with('edit', 'reservation restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function forceDelete($id)
    {
        try {
            $reservation = Reservation::withTrashed()->findOrFail($id);
            $reservation->forceDelete();


            return redirect()->route('reservation.index')->with('delete', 'reservation permanently deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }
    
//========================================================================================================================

}
