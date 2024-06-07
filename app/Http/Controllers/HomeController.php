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



    public function search(SearchRequest $request)
    {   
        $query = $request->input('query');
        $results = collect();
        try{ 
        if ($query) {
            $results = $this->searchModels($query, [Table::class ,Category::class,Dish::class,Order::class,Reservation::class,Review::class,]);
           
            return view('Admin.search.results', compact('results', 'query'));
        }
        }catch(\Exception $e)
        {
         return redirect()->back()->with('error,"cant Search'.$e->getMessage());
        }
    }

    private function searchModels($query, $models)
    {
        try{
            $results = collect();
            foreach ($models as $model) {
                $searchableColumns = $model::$searchable;
                $modelResults = $model::query();
                foreach ($searchableColumns as $column) {
                    $modelResults->orWhere($column, 'like', "%{$query}%");
                }
                $results = $results->merge($modelResults->get());
               
            }
            return $results;
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error,"searchModel File:cant Search'.$e->getMessage());  
        }
    }
}

