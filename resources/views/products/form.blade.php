@extends('layouts.master')

@section('page-header')
    Gestor de productos
@endsection

@push('customcss')
    <style>
        textarea {
            resize: none;
            padding: 5px;
        }
    </style>
@endpush

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(`#myform`).find(`input[name='product']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='sku']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='purchase_price']`).classMaxCharacters(11).classOnlyIntegers('.');
            $(`#myform`).find(`input[name='selling_price']`).classMaxCharacters(11).classOnlyIntegers('.');
            $(`#myform`).find(`input[name='customer_price']`).classMaxCharacters(11).classOnlyIntegers('.');

            $(".select2").select2({
                placeholder: "Selecciona",
                allowClear: true,
                language: 'es'
            });
        });
    </script>
@endpush

@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $action == 'create' ? 'Registrar' : 'Editar' }} producto</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create' ? route('productos.store') : route('productos.update', $product->id) }}" method="POST" id="myform" enctype="multipart/form-data">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Producto <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="product" name="product" value="{{ old('product', $product->product) }}">
                        {!! $errors->first('product', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">SKU <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                        {!! $errors->first('sku', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Marca <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="brand_id">
                            <option value=""></option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @if(old('brand_id', is_null($product->brand) ? null : $product->brand->id) == $brand->id) selected @endif>
                                    {{ $brand->brand }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('brand_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Color <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="color_id">
                            <option value=""></option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" @if(old('color_id', is_null($product->color_id) ? null : $product->color->id) == $color->id) selected @endif>
                                    {{ $color->color }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('color_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Talla <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="talla_id">
                            <option value=""></option>
                            @foreach($tallas as $talla)
                                <option value="{{ $talla->id }}" @if(old('talla_id', is_null($product->talla) ? null : $product->talla->id) == $talla->id) selected @endif>
                                    {{ $talla->talla }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('talla_id', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Género <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="gender">
                            <option value=""></option>
                            <option value="DAMA" @if(old('gender', $product->gender ?? null) == "DAMA") selected @endif>DAMA</option>
                            <option value="CABALLERO" @if(old('gender', $product->gender ?? null) == "CABALLERO") selected @endif>CABALLERO</option>
                            <option value="NIÑO" @if(old('gender', $product->gender ?? null) == "NIÑO") selected @endif>NIÑO</option>
                        </select>
                        {!! $errors->first('gender', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Precio de compra <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" onkeypress="return filterFloat(event, this);">
                        {!! $errors->first('purchase_price', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Precio de vendedor <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" onkeypress="return filterFloat(event, this);">
                        {!! $errors->first('selling_price', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Precio de cliente <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="customer_price" name="customer_price" value="{{ old('customer_price', $product->customer_price) }}" onkeypress="return filterFloat(event, this);">
                        {!! $errors->first('customer_price', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Descripción <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="description" rows="4" autocomplete="off">{{ old('description', $product->description) }}</textarea>
                        {!! $errors->first('description', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Imagen @if($action == 'create') <span class="text-danger">*</span> @endif</label>
                        <input class="form-control-file" type="file" id="path_image" name="path_image" value="{{ old('path_image') }}" accept="image/png,image/jpeg,image/jpg">
                        {!! $errors->first('path_image', '<small class="help-block text-danger">:message</small>') !!}
                        <br>
                    </div>
                    @if($action == 'edit')
                        <div class="col-lg-4">
                            <img src="data:image/{{ pathinfo($product->path_image)['extension'] }};base64,{{ base64_encode(\Storage::get($product->path_image)) }}" alt="Imagen" title="Imagen" width="100%" height="100%"/>
                            <br>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create' ? 'Registrar' : 'Actualizar' }}
                        </button>
                        <a href="{{ route('productos.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection