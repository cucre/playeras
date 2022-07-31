<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\InventorySummary;
use App\InventoryDetail;
use App\Http\Requests\InventoryRequest;
use Illuminate\Support\Facades\Storage;
use App\User;

use DataTables;

class InventoryController extends Controller {
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
        $vendedores = User::whereHas('roles', function($query) {
            $query->where('name', 'Vendedor');
        })->get();

        return \View::make('inventory.index')->with(compact('vendedores'));
    }

    /**
    * Obtiene la información para poblar del datatable
    *
    * @return Json
    */
    public function data() {
        $inventory_summaries = InventorySummary::orderBy('product_id')->with(['product']);

        $datatable = DataTables::eloquent($inventory_summaries)
            ->addColumn('path_image', function($row) {
                return '<img src="data:image/'. pathinfo($row->product->path_image)['extension'] .';base64,'. base64_encode(Storage::get($row->product->path_image)) .'" alt="Imagen" title="Imagen" width="100%" height="50px"/>';
            })
            ->addColumn('product', function($row) {
                $product = $row->product->product;

                return $product;
            })
            ->addColumn('sku', function($row) {
                $sku = $row->product->sku;

                return $sku;
            })
            ->addColumn('description', function($row) {
                $description = $row->product->description;

                return $description;
            })
            ->addColumn('brand', function($row) {
                $brand = $row->product->brand->brand;

                return $brand;
            })
            ->addColumn('color', function($row) {
                $color = $row->product->color->color;

                return $color;
            })
            ->addColumn('talla', function($row) {
                $talla = $row->product->talla->talla;

                return $talla;
            })
            ->addColumn('gender', function($row) {
                $gender = $row->product->gender;

                return $gender;
            })
            ->addColumn('purchase_price', function($row) {
                $purchase_price = '$ '. number_format($row->product->purchase_price, 2);

                return $purchase_price;
            })
            ->addColumn('selling_price', function($row) {
                $selling_price = '$ '. number_format($row->product->selling_price, 2);

                return $selling_price;
            })
            ->addColumn('customer_price', function($row) {
                $customer_price = '$ '. number_format($row->product->customer_price, 2);

                return $customer_price;
            })
            ->rawColumns(['path_image'])
            ->toJson(true);

        return $datatable;
    }

    /**
    * Obtiene la información del producto para revisar si se trata del SKU buscado
    *
    * @return Json
    */
    public function get_product(Request $request) {
        if (request()->ajax()) {
            $product = Product::with(['brand', 'color', 'talla', 'inventory_summary'])->where('sku', $request->sku)->first();

            if(isset($product)) {
                $product->path_image = '<img src="data:image/'. pathinfo($product->path_image)['extension'] .';base64,'. base64_encode(Storage::get($product->path_image)) .'" alt="Imagen" title="Imagen" width="100%" height="100%"/>';
            }

            return isset($product) ? json_encode(['code' => 1, 'data' => $product]) : json_encode(['code' => 0, 'message' => "El SKU ingresado \"$request->sku\" no existe. Intente nuevamente."]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\InventoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request) {
        //Guardamos el resumen
        $inventory_summary = InventorySummary::firstOrNew(['product_id' => $request->product_id]);
        $inventory_summary->created_by = auth()->user()->id;
        $inventory_summary->save();

        if($request->movement_type == 'SALIDA') {
            $inventory_summary->decrement('stock', $request->quantity);
        } else {
            $inventory_summary->increment('stock', $request->quantity);
        }

        //Guardamos el detalle
        $request->request->add(['created_by' => auth()->user()->id]);
        InventoryDetail::create($request->all());

        return redirect()->route('inventario.index');
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
