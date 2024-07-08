<?php

namespace App\Http\Services;

use App\Models\Dish;
use App\Models\Order;
use App\Models\reservation;

class OrderServices {

    function GetAllOrders(){
        
        return Order::onlyTrashed()->get();
    }

//========================================================================================================================
    function StoreOrders($request){
        //dd($request['user_id']);

        $check_reservation = Reservation::select('status')->Where('user_id' ,$request['user_id'])->get();

        //dd($check_reservation);
            if($check_reservation->first()->status == 'checkedin'){ 

                $order = new Order();
                $order->user_id = $request['user_id'];
                $order->table_id = $request['table_id'];
                $order->total_price = 0;
                $order->status = 'In Queue';
                $order->save();

                $totalPrice = 0;

                foreach ($request['dishes'] as $dishData) {
                    $dish = Dish::findOrFail($dishData['id']);
                    $quantity = $dishData['quantity'];
                    $order->dishes()->attach($dish->id, ['quantity' => $quantity]);
                    $totalPrice += $dish->price * $quantity;
                }

                $order->total_price = $totalPrice;
                $order->save();

                session()->flash('Add', 'Add created successfully');
            }else{
                    return redirect()->route('order.index')->with('error','There is No checked out Resevation');
                } 
    }

//========================================================================================================================
    function UpdateOrders($validatedOrder,$order){

        $check_order = Order::where('status', 'In Queue')->exists();

        if ($check_order) {
            $dishes = $validatedOrder['dishes'];

            $order->table_id = $validatedOrder['table_id'];
            $order->user_id = $validatedOrder['user_id'];
            $order->status = $validatedOrder['status'];

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
        }
    }

//========================================================================================================================
    function DestroyOrders($order){

        $order->dishes()->updateExistingPivot($order->dishes->pluck('id'), ['deleted_at' => now()]);    
        $order->delete();
        session()->flash('delete', 'Delete successfully');
    }

//========================================================================================================================
    function RestoreOrders($id){

        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();
        $order->dishes()->withTrashed()->updateExistingPivot($order->dishes->pluck('id'), ['deleted_at' => null]);
    }

//========================================================================================================================
    function ForceDeleteOrders($id){

        $order = Order::withTrashed()->findOrFail($id);
        $order->forceDelete();
    }

//========================================================================================================================

}