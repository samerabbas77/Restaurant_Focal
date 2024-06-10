<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\trait\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;

class TableController extends Controller
{
    use ApiResponse;
    public function index()
    {   try {
        $tables = Table::whereNull('deleted_at')->get();
        return $this->successResponse(TableResource::collection($tables), 'Tables show successfully.');
    } catch (\Exception $e) {
        return $this->errorResponse('An error occurred while fetching the tables.', ['error' => $e->getMessage()]);
    }
    }
   // ==================================================================================================================
    public function available()
    {    try {
        $tables = Table::where('Is_available', 'available')->whereNull('deleted_at')->get();
        return $this->successResponse(TableResource::collection($tables), 'Available tables show successfully.');
    } catch (\Exception $e) {
        return $this->errorResponse('An error occurred while fetching the available tables.', ['error' => $e->getMessage()]);
    }
    }
    // ==================================================================================================================
    public function filterByChairs($number)
    {     try {
        $tables = Table::where('chair_number', $number)->whereNull('deleted_at')->get();
        return $this->successResponse(TableResource::collection($tables), 'Tables filtered by chair number show successfully.');
    } catch (\Exception $e) {
        return $this->errorResponse('An error occurred while filtering tables by chair number.', ['error' => $e->getMessage()]);
    }
    }
    // ==================================================================================================================
    public function filteravailableByChairs($number)
    {     try {
        $tables = Table::where('Is_available', 'available')
                    ->where('chair_number', $number)
                    ->whereNull('deleted_at')
                    ->get();
        return $this->successResponse(TableResource::collection($tables), 'Available tables filtered by chair number show successfully.');
    } catch (\Exception $e) {
        return $this->errorResponse('An error occurred while filtering available tables by chair number.', ['error' => $e->getMessage()]);
    }
    }





}
