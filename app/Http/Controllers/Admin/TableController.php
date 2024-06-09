<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Requests\TableRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTableRequest;

class TableController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:ادارة الطاولات|الطاولات'])->only('index');
        $this->middleware(['permission:اضافة طاولة'])->only('store');
        $this->middleware(['permission:تعديل طاولة'])->only('update');
        $this->middleware(['permission:حذف طاولة'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة طاولة'])->only('restore');
    }

//========================================================================================================================

    public function index()
    {
        try {
            $tables = Table::all();
            $trachedTables = Table::onlyTrashed()->get();
            return view('Admin.tables', compact('tables', 'trachedTables'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }

    }

//========================================================================================================================

    public function store(TableRequest $request)
    {

        try {
            Table::create($request->validated());
            session()->flash('Add', 'Add succsesfuly');
            return redirect()->route('tables.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create table: ' . $e->getMessage());
        }

    }

//========================================================================================================================

    public function update(UpdateTableRequest $request, Table $table)
    {

        try {
            $table->update($request->validated());
            session()->flash('edit', 'edit succsesfuly');
            return redirect()->route('tables.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update table: ' . $e->getMessage());
        }

    }

//========================================================================================================================

    public function destroy(Table $table)
    {
        try {
            $table->delete();
            session()->flash('delete', 'delete succsesfuly');
            return redirect()->route('tables.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }

    }

//========================================================================================================================

    public function restore($id)
    {
        try {
            $table = Table::withTrashed()->findOrFail($id);
            $table->restore();

            return redirect()->route('tables.index')->with('edit', 'Table restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function forceDelete($id)
    {
        try {
            $table = Table::withTrashed()->findOrFail($id);
            $table->forceDelete();

            return redirect()->route('tables.index')->with('delete', 'Table permanently deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

//========================================================================================================================

}
