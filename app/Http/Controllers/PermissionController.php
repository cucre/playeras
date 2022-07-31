<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*$this->middleware('permission:create_report')->only(['create', 'store']);
        $this->middleware('permission:index_report')->only('index');
        $this->middleware('permission:edit_report')->only(['edit', 'update']);
        $this->middleware('permission:show_report')->only('show');
        $this->middleware('permission:delete_report')->only('destroy');*/
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('permissions.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        $role = new Role();
        return view('permissions.create', compact('permissions','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name,'description'=>$request->description]);
        $role->permissions()->sync($request->get('permissions'));
        return redirect()->route('permisos.index')->with('info', 'Rol guardado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = Permission::get();
        $role = Role::find($id);
        return view('permissions.edit', compact('permissions','role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update(['name' => $request->name,'description'=>$request->description]);
        $role->syncPermissions($request->get('permissions'));
        return redirect()->route('permisos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('permisos.index');
    }
}
