<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Models\DishOrder;
use App\Models\reservation;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Validation\Rules\Exists;

class OrderController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:ادارةالطلبات|الطلبات'])->only('index');
        $this->middleware(['permission:اضافة طلب'])->only('store');
        $this->middleware(['permission:تعديل طلب'])->only('update');
        $this->middleware(['permission:حذف طلب'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة طلب'])->only('restore');
    }

//========================================================================================================================

    public function index()
    {
        try {
            $orders = Order::all();
            $tables = Table::all();
            $dishes = Dish::all();
            $users = User::all();
            $trashedOrders = Order::onlyTrashed()->get();
            return view('Admin.order', compact('orders', 'tables', 'dishes', 'users', 'trashedOrders'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================
    public function store(OrderRequest $request)
    {
        try {
            $check_reservation = Reservation::where('status','Chackout')
                                             ->exists();
            
            if($check_reservation){ 

                $validated = $request->validated();

                $order = new Order();
                $order->user_id = $validated['user_id'];
                $order->table_id = $validated['table_id'];
                $order->total_price = 0;
                $order->status = 'In Queue';
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
            } 
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

public function update(UpdateOrderRequest $request, Order $order)
{
    try {
        
        $check_order = Order::where('status', 'In Queue')->exists();

        if ($check_order) {
            $dishes = $request->input('dishes');

            $order->table_id = $request->table_id;
            $order->user_id = $request->user_id;
            $order->status = $request->status;

            $totalPrice = 0;
            $syncData = [];
            foreach ($dishes as $dishData) {
                $dish = Dish::findOrFail($dishData['id']);
                $quantity = $dishData['quantity'];
                
                $syncData[$dish->id] = ['quantity' => $quantity];
                $totalPrice += $dish->price * $quantity;
            }

            $order->total_price = $totalPrice;
            $order->save();
            $order->dishes()->sync($syncData);

            session()->flash('edit', 'Edit Successfully');
            return redirect()->route('order.index');
        }else{
            session()->flash('error', 'cannot edit on this order');
            return redirect()->route('order.index');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}


//========================================================================================================================

    public function destroy(Order $order)
    {
        try {
            $order->dishes()->updateExistingPivot($order->dishes->pluck('id'), ['deleted_at' => now()]);    
            $order->delete();
            session()->flash('delete', 'Delete successfully');
            return redirect()->route('order.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

//========================================================================================================================
    public function restore($id)
    {
        try {
            
            $order = Order::withTrashed()->findOrFail($id);
            $order->restore();

            $order->dishes()->withTrashed()->updateExistingPivot($order->dishes->pluck('id'), ['deleted_at' => null]);

            return redirect()->route('order.index')->with('edit', 'Order restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Order: ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function forceDelete($id)
    {
        try {
            $order = Order::withTrashed()->findOrFail($id);
            $order->forceDelete();
            return redirect()->route('order.index')->with('delete', 'Order permanently deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Order: ' . $e->getMessage());
        }
    }
    
//========================================================================================================================

}
