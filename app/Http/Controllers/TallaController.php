<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Talla;
use App\Http\Requests\TallaRequest;

use DataTables;

class TallaController extends Controller
{

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
        return \View::make('tallas.index');
    }

    public function data() {
        $tallas = Talla::orderBy('talla');

        $datatable = DataTables::eloquent($tallas)
            ->addColumn('accion',function($row) {
                return \View::make('tallas.buttons')->with(compact('row'))->render();
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
    public function create(Talla $talla)
    {
        $action = 'create';

        return \View::make('tallas.form')->with(compact('action', 'talla'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TallaRequest $request)
    {
        $request->request->add(['created_by' => auth()->user()->id]);

        Talla::create($request->all());

        return redirect()->route('tallas.index');
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
    public function edit(Talla $talla)
    {
        $action = 'edit';

        return \View::make('tallas.form')->with(compact('action', 'talla'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TallaRequest $request, Talla $talla)
    {
        $talla->update($request->all());

        return redirect()->route('tallas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Talla $talla)
    {
        $talla->delete();

        return redirect()->route('tallas.index');
    }
}
