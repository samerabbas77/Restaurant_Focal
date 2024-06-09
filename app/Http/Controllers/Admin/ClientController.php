<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:اضافة زبون']);

    }

//========================================================================================================================

    public function index()
    {
        try {
            $users = User::where('role', '["Customer"]')->get();
            return view('Admin.client', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function store(UserRequest $request)
    {

        try {
            $user = $request->validated();

            $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => ["Customer"],
            ]);
            $user->assignRole(["Customer"]);
            session()->flash('Add', 'Add Susseccfully');
            return redirect()->route('client.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================

}
