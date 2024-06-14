<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserReq;
use App\Models\Table;
use app\Models\User;
use Spatie\Permission\Models\Role;
use Hash;
use Illuminate\Support\Arr;
use DB;
use illuminate\Support\Facades\Log;
use App\Http\Requests\UserRequest;
use App\Http\Traits\UserManagementTrait;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use UserManagementTrait;

    public function __construct()
    {

        $this->middleware(['role:Admin', 'permission:قائمة المستخدمين'])->only('index');
        $this->middleware(['role:Admin', 'permission:اضافة مستخدم'])->only(['create', 'store']);
        $this->middleware(['role:Admin', 'permission:تعديل مستخدم'])->only(['edit', 'update']);
        $this->middleware(['role:Admin', 'permission:حذف مستخدم'])->only('destroy');


    }

//========================================================================================================================

    public function index()
    {
        try {
            $users = $this->getAllUsers();
            return view('Admin.users.index', compact('users'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

//========================================================================================================================

    public function create()
    {
        try {
            $roles = $this->getRoles();
            return view('Admin.users.add', compact('roles'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

//========================================================================================================================

    public function store(UserReq $request)
    {
        try {
            $validatedData = $request->validated();
            $this->createUser($validatedData);
            return redirect()->route('users.index')
                ->with('success', 'User created successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->withInput()->with('error', 'Unable to create user at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function edit(string $id)
    {
        try {
            $data = $this->getUserWithRoles($id);
            $user = $data['user'];
            $roles = $data['roles'];
            $userRole = $data['userRole'];
            return view('Admin.users.edit', compact('user', 'roles', 'userRole'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Unable to retrieve user or roles at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function update(UserReq $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $this->updateUser($validatedData, $id);

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->withInput()->with('error', 'Unable to update user at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function destroy(string $id)
    {
        try {
            $this->deleteUser($id);
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
//========================================================================================================================

}
