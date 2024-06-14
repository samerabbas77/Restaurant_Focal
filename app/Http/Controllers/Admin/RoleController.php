<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Traits\RoleManagementTrait;
use App\Http\Traits\UserManagementTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use RoleManagementTrait, UserManagementTrait;

    public function __construct()
    {
        $this->middleware(['role:Admin', 'permission:صلاحيات المستخدمين'])->only('index');
        $this->middleware(['role:Admin', 'permission:عرض صلاحية'])->only('show');
        $this->middleware(['role:Admin', 'permission:اضافة صلاحية'])->only(['store', 'create']);
        $this->middleware(['role:Admin', 'permission:تعديل صلاحية'])->only(['edit', 'update']);
        $this->middleware(['role:Admin', 'permission:حذف صلاحية'])->only('destroy');
    }
    
//========================================================================================================================

    public function index(Request $request)
    {
        try {
            $roles = Role::all();
            return view('Admin.roles.index', compact('roles'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Unable to retrieve roles at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function create()
    {
        try {
            $permissions = Permission::all();
            return view('Admin.roles.add', compact('permissions'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Unable to retrieve permissions at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function store(RoleRequest $request)
    {
        try {
            $role = $request->validated();
            $this->createRole($role);
            return redirect()->route('roles.index')->with('success', 'Role created successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->withInput()->with('error', 'Unable to create role at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function show(string $id)
    {
        try {
            $data = $this->showRole($id);
            $role = $data['role'];
            $rolePermissions = $data['rolePermissions'];

            return view('Admin.roles.show', compact('role', 'rolePermissions'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Unable to retrieve role details at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function edit(string $id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('Admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

//========================================================================================================================

    public function update(RoleRequest $request, string $id)
    {
        try {

            $role = $request->validated();

            $this->updateRole($role, $id);

            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->withInput()->with('error', 'Unable to update role at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function destroy(string $id)
    {
        try {
            $this->deleteRole($id);

            return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

//========================================================================================================================

}
