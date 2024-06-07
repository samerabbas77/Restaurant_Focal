<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Models\Reservation as ModelsReservation;
use App\Models\Review;

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
        return view('home');
    }


 
}

