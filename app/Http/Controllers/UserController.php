<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
//use App\Company;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;

use DataTables;

class UserController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:Administrador');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('users.index');
    }

    public function data() {
        $users = User::orderBy('name')->withTrashed()->with(['roles']);

        $datatable = DataTables::eloquent($users)
            ->editColumn('name', function($row) {
                return $row->full_name;
            })
            ->addColumn('role', function($row) {
                $role = $row->roles->first()->description;
                return $role;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion',function($row) {
                return \View::make('users.buttons')->with(compact('row'))->render();
            })
            ->addColumn('status', function($row) {
                return is_null($row->deleted_at) ? 'Activo' : 'Inactivo desde ' . $row->deleted_at->format('d-m-Y H:i');
            })
            ->addColumn('avatar', function($row) {
                return '<img src="/assets/img/user/user-1.jpg" class="img-rounded height-30">';
            })
            ->rawColumns(['status', 'accion', 'avatar', 'role'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $usuario) {
        $action = 'create';
        $roles  = Role::get();

        return \View::make('users.form')->with(compact('action', 'usuario', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
            'password'   => '12345'
        ]);

        $user = User::create($request->all());

        $user->assignRole($request->rol);

        return redirect()->route('usuarios.index');
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
    public function edit(User $usuario) {
        $action = 'edit';
        $roles  = Role::get();

        return \View::make('users.form')->with(compact('action', 'usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $usuario) {
        $usuario->update($request->all());

        $usuario->syncRoles([$request->rol]);

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario) {
        $usuario->delete();

        return redirect()->route('usuarios.index');
    }
}