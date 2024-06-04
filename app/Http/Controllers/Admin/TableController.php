<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Requests\TableRequest;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{ $tables = Table::all();
        return view('Admin.tables', compact('tables'));}
        catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            return view('tables.create');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'An error created  ' . $e->getMessage());}

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TableRequest $request)
    {
        
        try
        {
        Table::create($request->validated());
        session()->flash('Add','Add succsesfuly');
        return redirect()->route('tables.index');
        }
        catch (Exception $e) {
        return redirect()->back()->with('error', 'Failed to create table: ' . $e->getMessage());
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        try{
            return view('tables.show');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'An error Show  ' . $e->getMessage());}
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        try{
        $table = Table::find($id);
        session()->flash('edit','edit succsesfuly');
        return view('tables.edit', compact('table'));
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'An error edit  ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TableRequest $request, Table $table)
    {
      
        try {
            $table->update($request->validated());
            session()->flash('edit','edit succsesfuly');
            return redirect()->route('tables.index');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update table: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        try {
            $table->delete();
            session()->flash('delete','delete succsesfuly');
            return redirect()->route('tables.index');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
        
    }
}
