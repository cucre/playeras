<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\Color;
use App\Talla;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

use DataTables;

class ProductController extends Controller {
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
        return \View::make('products.index');
    }

    /**
    * Obtiene la información para poblar del datatable
    *
    * @return Json
    */
    public function data() {
        $products = Product::orderBy('product')->with(['brand', 'color', 'talla']);

        $datatable = DataTables::eloquent($products)
            ->addColumn('path_image', function($row) {
                return '<img src="data:image/'. pathinfo($row->path_image)['extension'] .';base64,'. base64_encode(Storage::get($row->path_image)) .'" alt="Imagen" title="Imagen" width="100%" height="50px"/>';
            })
            ->addColumn('brand', function($row) {
                $brand = $row->brand->brand;

                return $brand;
            })
            ->addColumn('color', function($row) {
                $color = $row->color->color;

                return $color;
            })
            ->addColumn('talla', function($row) {
                $talla = $row->talla->talla;

                return $talla;
            })
            ->addColumn('purchase_price', function($row) {
                $purchase_price = '$ '. number_format($row->purchase_price, 2);

                return $purchase_price;
            })
            ->addColumn('selling_price', function($row) {
                $selling_price = '$ '. number_format($row->selling_price, 2);

                return $selling_price;
            })
            ->addColumn('customer_price', function($row) {
                $customer_price = '$ '. number_format($row->customer_price, 2);

                return $customer_price;
            })
            ->addColumn('accion', function($row) {
                return \View::make('products.buttons')->with(compact('row'))->render();
            })
            ->rawColumns(['accion', 'path_image'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product) {
        $action = 'create';
        $brands  = Brand::get();
        $colors  = Color::get();
        $tallas  = Talla::get();

        return \View::make('products.form')->with(compact('action', 'product', 'brands', 'colors', 'tallas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request) {
        $image = $request->file('path_image');
        $fileName = '/images/'. \Str::random(20) .'.'. $image->getClientOriginalExtension();

        Storage::put(
            $fileName,
            file_get_contents($request->file('path_image')->getRealPath()),
            'public'
        );

        $request->request->add(['created_by' => auth()->user()->id]);
        $requestData = $request->all();
        $requestData['path_image'] = $fileName;

        Product::create($requestData);

        return redirect()->route('productos.index');
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
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        $action = 'edit';
        $brands  = Brand::get();
        $colors  = Color::get();
        $tallas  = Talla::get();

        return \View::make('products.form')->with(compact('action', 'product', 'brands', 'colors', 'tallas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product) {
        $requestData = $request->all();

        if ($request->has('path_image')) {
            $image = $request->file('path_image');
            $fileName = '/images/'. \Str::random(20) .'.'. $image->getClientOriginalExtension();
            Storage::delete($product->path_image);

            Storage::put(
                $fileName,
                file_get_contents($request->file('path_image')->getRealPath()),
                'public'
            );

            $requestData['path_image'] = $fileName;
        }

        $product->update($requestData);

        return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        Storage::delete($product->path_image);
        $product->delete();

        return redirect()->route('productos.index');
    }
}