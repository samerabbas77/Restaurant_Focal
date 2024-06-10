<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;

class TableController extends Controller
{
    public function index()
    {   try {
        $tables = Table::whereNull('deleted_at')->get();
        return TableResource::collection($tables);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while fetching the tables.'], 500);
    }
    }
   // ==================================================================================================================
    public function available()
    {    try {
        $tables = Table::where('Is_available', 'available')->whereNull('deleted_at')->get();
        return TableResource::collection($tables);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while fetching the available tables.'], 500);
    }
    }
    // ==================================================================================================================
    public function filterByChairs($number)
    {     try {
        $tables = Table::where('chair_number', $number)->whereNull('deleted_at')->get();
        return TableResource::collection($tables);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while filtering tables by chair number.'], 500);
    }
    }
    // ==================================================================================================================
    public function filteravailableByChairs($number)
    {     try {
        $tables = Table::where('Is_available', 'available')
                    ->where('chair_number', $number)
                    ->whereNull('deleted_at')
                    ->get();
        return TableResource::collection($tables);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while filtering available tables by chair number.'], 500);
    }
    }





}
