<?php

namespace App\Http\Services;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Resources\TableResource;
use App\Http\Traits\ApiTraits\ApiResponse;

class TableService
{
    use ApiResponse;

    public function getTables(Request $request)
    {

        $tables =Table::with('reservations')->whereNull('deleted_at')->get();
        return $this->successResponse(TableResource::collection($tables), 'Tables shown successfully.');

    }
    // ======================================================================================================================
    public function getAvailableTables(Request $request)
    {
        $tables = Table::with('reservations')
                    ->where('Is_available', 'available')
                    ->whereNull('deleted_at')
                    ->get();
        return $this->successResponse(TableResource::collection($tables), 'Available tables shown successfully.');
    }
    // ======================================================================================================================
    public function filterTablesByChairs(Request $request, $number)
    {
        $tables = Table::with('reservations')
        ->where('chair_number', $number)
        ->whereNull('deleted_at')
        ->get();
        return $this->successResponse(TableResource::collection($tables), 'Tables filtered by chair number shown successfully.');
    }
    // ======================================================================================================================
    public function filterAvailableTablesByChairs(Request $request, $number)
    {
        $tables =Table::with('reservations')
        ->where('Is_available', 'available')
        ->where('chair_number', $number)
        ->whereNull('deleted_at')
        ->get();
        return $this->successResponse(TableResource::collection($tables), 'Available tables filtered by chair number shown successfully.');
    }
}
