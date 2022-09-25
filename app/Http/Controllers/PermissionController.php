<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $permissions = Permission::latest()->simplePaginate(10);
        $permissions = Permission::latest()->paginate(10);
        // return $permissions;
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all();
        return view('permissions.create', compact('roles'));
    }
    public function crud_create()
    {
        //
        $roles = Role::all();
        return view('permissions.crud_create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;
        try {
            $permission = Permission::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            if (!empty($request->roles)) {
                $permission->syncRoles($request->roles);
            }
            return redirect()->route('permissions.index')->with('success', 'Permission created!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Error: Permission not created!');
        }
    }
    public function crud_store(Request $request)
    {
        //
        // return $request;
        try {
            $name = $request->name;
            $permissions = [
                'add-' . $name,
                'view-' . $name,
                'edit-' . $name,
                'delete-' . $name,
            ];
            foreach ($permissions as $value) {
                $permission = Permission::create([
                    'name' => $value,
                    'guard_name' => 'web'
                ]);
                if (!empty($request->roles)) {
                    $permission->syncRoles($request->roles);
                }
            }
            return redirect()->route('permissions.index')->with('success', 'Permission created!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Error: Permission not created!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
        // return $permission->roles;
        $roles = Role::all();
        $roles_permission = $permission->roles->pluck('id')->toArray();
        return view('permissions.edit', compact('permission', 'roles', 'roles_permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
        // return $permission;
        // return $request;
        try {
            $permission->update([
                'name' => $request->name
            ]);
            if (!empty($request->roles)) {
                $permission->syncRoles($request->roles);
            }
            return redirect()->route('permissions.index')->with('success', 'Permission updated!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Error: Permission not updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
        try {
            $permission->delete();
            return redirect()->back()->with('success', 'Permission deleted!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Error: Permission not deleted!');
        }
    }
}
