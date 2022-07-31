<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Http\Requests\BrandRequest;

use DataTables;

class BrandController extends Controller {
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
        return \View::make('brands.index');
    }

    /**
    * Obtiene la información para poblar del datatable
    *
    * @return Json
    */
    public function data() {
        $brands = Brand::orderBy('brand');

        $datatable = DataTables::eloquent($brands)
            ->addColumn('accion', function($row) {
                return \View::make('brands.buttons')->with(compact('row'))->render();
            })
            ->rawColumns(['accion'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function create(Brand $brand) {
        $action = 'create';

        return \View::make('brands.form')->with(compact('action', 'brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request) {
        $request->request->add(['created_by' => auth()->user()->id]);

        Brand::create($request->all());

        return redirect()->route('marcas.index');
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
     * @param  Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand) {
        $action = 'edit';

        return \View::make('brands.form')->with(compact('action', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\BrandRequest  $request
     * @param  Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand) {
        $brand->update($request->all());

        return redirect()->route('marcas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand) {
        $brand->delete();

        return redirect()->route('marcas.index');
    }
}