<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Http\Services\TableService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;

class TableController extends Controller
{

    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }
// ======================================================================================================================
    public function index(Request $request)
    {
        try {
            return $this->tableService->getTables($request);

        } catch (\Exception $e) {
            return $this->tableService->errorResponse('An error occurred while fetching the tables.', ['error' => $e->getMessage()]);
        }
    }
// ======================================================================================================================
    public function available(Request $request)
    {
        try {
            return $this->tableService->getAvailableTables($request);
        } catch (\Exception $e) {
            return $this->tableService->errorResponse('An error occurred while fetching the available tables.', ['error' => $e->getMessage()]);
        }
    }
// ======================================================================================================================
    public function filterByChairs(Request $request, $number)
    {
        try {
            return $this->tableService->filterTablesByChairs($request, $number);
        } catch (\Exception $e) {
            return $this->tableService->errorResponse('An error occurred while filtering tables by chair number.', ['error' => $e->getMessage()]);
        }
    }
// ======================================================================================================================
    public function filterAvailableByChairs(Request $request, $number)
    {
        try {
            return $this->tableService->filterAvailableTablesByChairs($request, $number);
        } catch (\Exception $e) {
            return $this->tableService->errorResponse('An error occurred while filtering available tables by chair number.', ['error' => $e->getMessage()]);
        }
    }
}
