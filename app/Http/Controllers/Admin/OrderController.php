<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Table;
use App\Models\DishOrder;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        try{
            $orders = Order::all();
            $tables = Table::all();
            $dishes = Dish::all();
            $users = User::all();

            return view('Admin.order',compact( 'orders','tables','dishes','users'));
        }catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }    
    }

//========================================================================================================================

public function store(OrderRequest $request)
{
    try {
        $validated = $request->validated();

        $order = new Order();
        $order->user_id = $validated['user_id'];
        $order->table_id = $validated['table_id'];
        $order->total_price = 0;
        $order->status = 'accept';
        $order->save();

        $totalPrice = 0;

        foreach ($validated['dishes'] as $dishData) {
            $dish = Dish::findOrFail($dishData['id']);
            $quantity = $dishData['quantity'];
            $order->dishes()->attach($dish->id, ['quantity' => $quantity]);
            $totalPrice += $dish->price * $quantity;
        }

        $order->total_price = $totalPrice;
        $order->save();

        session()->flash('Add', 'Add created successfully');
        return redirect()->route('order.index');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}

//========================================================================================================================

public function edit($id)
{
    $order = Order::findOrFail($id);
    $tables = Table::all();
    $users = User::all();
    $dishes = Dish::all();
    return view('Admin.orders_edit', compact('order', 'tables', 'users', 'dishes'));
}

//========================================================================================================================


    // public function update(ReservationRequest $request, reservation $reservation)
    // {

    //     try{
    //        $request->validated();

    //        $reservation->user_id = $request->user_id;
    //        $reservation->table_id = $request->table_id;
    //        $reservation->start_date = $request->start_date;
    //        $reservation->end_date = $request->end_date;
    //        $reservation->save();

    //        session()->flash('edit','ُEdit Susseccfully');
    //        return redirect()->route('order.update');
    //     }catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
    //     }  
    // }

//========================================================================================================================

public function destroy(Order $order)
{
    try {
        $order->delete();
        session()->flash('delete', 'Delete successfully');
        return redirect()->route('order.index');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}
//========================================================================================================================
}
