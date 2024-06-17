<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Models\Review;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Models\Reservation as ModelsReservation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $tables = Table::count();
        $ava_tables =Table::where('Is_available','available')
                            ->count();
        $unava_tables =Table::where('Is_available','unavailable')
                            ->count();

        $reservation = Reservation::count();
        $done_reserv = Reservation::where('status','done')
        ->count();
        $checkedin_reserv = Reservation::where('status', 'checkedin')
        ->count();
        $checkedout_reserv = Reservation::where('status', 'checkedout')
        ->count();

        $orders = Order::count();
        $completed_order = Order::where('status', 'Completed')
        ->count(); 
        $queue_order = Order::where('status', 'In Queue')
        ->count(); 
        $received_order = Order::where('status', 'Order Received')
        ->count(); 
        return view('counters',compact('users','tables','ava_tables','unava_tables',
                                       'reservation','done_reserv','checkedin_reserv','checkedout_reserv',
                                       'orders','completed_order','queue_order','received_order'));
    }


 
}

