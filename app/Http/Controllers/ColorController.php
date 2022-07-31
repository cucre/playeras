<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Color;
use App\Http\Requests\ColorRequest;

use DataTables;

class ColorController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:Administrador');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('colors.index');
    }

    public function data() {
        $colors = Color::orderBy('color');

        $datatable = DataTables::eloquent($colors)
            ->addColumn('accion',function($row) {
                return \View::make('colors.buttons')->with(compact('row'))->render();
            })
            ->rawColumns(['accion'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Color $color)
    {
        $action = 'create';

        return \View::make('colors.form')->with(compact('action', 'color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorRequest $request)
    {
        $request->request->add(['created_by' => auth()->user()->id]);

        Color::create($request->all());

        return redirect()->route('colores.index');
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
    public function edit(Color $color)
    {
        $action = 'edit';

        return \View::make('colors.form')->with(compact('action', 'color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->all());

        return redirect()->route('colores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('colores.index');
    }
}
