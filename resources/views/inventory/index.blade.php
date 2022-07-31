@extends('layouts.master')

@section('page-header')
    Inventario
@endsection

@push('customcss')
    <style>
        textarea {
            resize: none;
            padding: 5px;
        }

        .no-border {
            border: 0;
            box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
            background: transparent !important;
        }
    </style>
    <link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-autofill-bs4/css/autofill.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-colreorder-bs4/css/colreorder.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-keytable-bs4/css/keytable.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-rowreorder-bs4/css/rowreorder.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
@endpush

@push('customjs')
    <script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-autofill/js/dataTables.autofill.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-autofill-bs4/js/autofill.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-colreorder/js/dataTables.colreorder.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-colreorder-bs4/js/colreorder.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-keytable/js/dataTables.keytable.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-keytable-bs4/js/keytable.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-rowreorder/js/dataTables.rowreorder.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-rowreorder-bs4/js/rowreorder.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-select/js/dataTables.select.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-select-bs4/js/select.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/pdfmake/build/pdfmake.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>
    <script src="/assets/plugins/jszip/dist/jszip.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            let sku_input = getValue('sku');

            if(!valIsEmpty(sku_input)) {
                $.ajax({
                    url : '{!! route('inventario.get_product') !!}',
                    method: "GET",
                    data: { sku: sku_input, _token: "{{ csrf_token() }}" }
                })
                .done(function(data) {
                    data = JSON.parse(data);

                    if(data.code == 1) { // Success
                        let purchase_price = currencyFormat(data.data.purchase_price);
                        let selling_price = currencyFormat(data.data.selling_price);
                        let customer_price = currencyFormat(data.data.customer_price);
                        setValue('product_id', data.data.id);
                        setValue('product_show', data.data.product);
                        setValue('sku_show', data.data.sku);
                        setValue('brand_show', data.data.brand.brand);
                        setValue('color_show', data.data.color.color);
                        setValue('talla_show', data.data.talla.talla);
                        setValue('gender_show', data.data.gender);
                        setValue('gender_show', data.data.gender);
                        setValue('purchase_price_show', purchase_price);
                        setValue('selling_price_show', selling_price);
                        setValue('customer_price_show', customer_price);
                        setValue('stock_show', (valIsEmpty(data.data.inventory_summary) ? 0 : data.data.inventory_summary.stock));
                        $("textarea#description_show").text(data.data.description);
                        $("#div_path_image").show();
                        $("#div_path_image").html(data.data.path_image);
                    }
                });
            }
        });
        let tabla;

        $(document).ready(function() {
            $(`#myform`).find(`input[name='sku']`).classMaxCharacters(255);
            $(`#myform`).find(`input[name='quantity']`).classMaxCharacters(10).classOnlyIntegers();

            tabla = $('#tabla').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('inventario.data') !!}',
                columns: [
                    { data: 'path_image', name: 'path_image'},
                    { data: 'product', name: 'product'},
                    { data: 'sku', name: 'sku'},
                    { data: 'description', name: 'description'},
                    { data: 'brand', name: 'brand'},
                    { data: 'color', name: 'color'},
                    { data: 'talla', name: 'talla'},
                    { data: 'gender', name: 'gender'},
                    { data: 'purchase_price', name: 'purchase_price'},
                    { data: 'selling_price', name: 'selling_price'},
                    { data: 'customer_price', name: 'customer_price'},
                    { data: 'stock', name: 'stock'},
                ],
                autoWidth: true,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'excel',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'csv',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'pdf ',
                        footer: true,
                        messageTop: 'Fecha de descarga '
                    }
                ]
            });

            $(".select2").select2({
                placeholder: "Selecciona",
                allowClear: true,
                language: 'es'
            });

            $("#myform").on("focusout", "#sku", function(e) {
                setValue('product_id', "");
                setValue('quantity', "");
                $('.help-block .text-danger').html('');
                $('.select2').val(null).trigger('change');

                if(!valIsEmpty($(this).val())) {
                    $.ajax({
                        url : '{!! route('inventario.get_product') !!}',
                        method: "GET",
                        data: { sku: $(this).val(), _token: "{{ csrf_token() }}" }
                    })
                    .done(function(data) {
                        data = JSON.parse(data);

                        if(data.code == 1) { // Success
                            let purchase_price = currencyFormat(data.data.purchase_price);
                            let selling_price = currencyFormat(data.data.selling_price);
                            let customer_price = currencyFormat(data.data.customer_price);
                            setValue('product_id', data.data.id);
                            setValue('product_show', data.data.product);
                            setValue('sku_show', data.data.sku);
                            setValue('brand_show', data.data.brand.brand);
                            setValue('color_show', data.data.color.color);
                            setValue('talla_show', data.data.talla.talla);
                            setValue('gender_show', data.data.gender);
                            setValue('gender_show', data.data.gender);
                            setValue('purchase_price_show', purchase_price);
                            setValue('selling_price_show', selling_price);
                            setValue('customer_price_show', customer_price);
                            setValue('stock_show', (valIsEmpty(data.data.inventory_summary) ? 0 : data.data.inventory_summary.stock));
                            $("textarea#description_show").text(data.data.description);
                            $("#div_path_image").show();
                            $("#div_path_image").html(data.data.path_image);
                        } else {
                            $("#mensaje").find("#message").text(data.message);
                            $("#mensaje").modal('show');
                        }
                    })
                    .fail(function(data) {
                        $("#mensaje").find("#message").text('Ocurrió un error en el sistema. Intente nuevamente.');
                        $("#mensaje").modal('show');
                    });
                }
            });

            $("#myform").on("change", "#movement_type", function(e) {
                e.preventDefault();
                let movement_type = $(this).val();

                if(movement_type == 'SALIDA') {
                    $("#sale_type_show").show();
                    $("#vendedor_show").hide();
                } else if(movement_type == 'DEVOLUCIÓN') {
                    $("#vendedor_show").show();
                } else {
                    $("#sale_type_show").hide();
                    $("#vendedor_show").hide();
                }
            });

            $('#sale_type').change(function(e) {
                e.preventDefault();

                if($(this).val() == 'VENDEDOR') {
                    $("#vendedor_show").show();
                } else {
                    $("#vendedor_show").hide();
                }
            });
        });

        function clear() {
            $('#showform')[0].reset();
            $('textarea').text("");
            $('.select2').val(null).trigger('change');
            $("#div_path_image").hide();
        }

        function currencyFormat(num) {
            return '$ '+ num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
    </script>
@endpush

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="mensaje" tabindex="-1" role="dialog" aria-labelledby="mensaje" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensajeModalLabel">Atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 text-center">
                        <i class="fas fa-exclamation-circle fa-5x text-warning"></i>
                    </div>
                    <div class="col-lg-12 text-center">
                        <p id="message"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Registrar movimiento</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('inventario.store') }}" method="POST" id="myform" class="form-horizontal form-padding">
                        @csrf
                        <input class="form-control" type="hidden" id="product_id" name="product_id" value="{{ old('product_id') }}">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">SKU <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" id="sku" name="sku" value="{{ old('sku') }}">
                                {!! $errors->first('sku', '<small class="help-block text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Tipo <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <select class="form-control select2" id="movement_type" name="movement_type" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="ENTRADA" @if(old('movement_type') == "ENTRADA") selected @endif>ENTRADA</option>
                                    <option value="SALIDA" @if(old('movement_type') == "SALIDA") selected @endif>SALIDA</option>
                                    <option value="DEVOLUCIÓN" @if(old('movement_type') == "DEVOLUCIÓN") selected @endif>DEVOLUCIÓN</option>
                                </select>
                                {!! $errors->first('movement_type', '<small class="help-block text-danger">:message</small>') !!}
                            </div>
                        </div>
                        <div class="form-group row" style="@if(old('movement_type') != "SALIDA" || old('movement_type') == NULL) display: none; @endif" id="sale_type_show">
                            <label class="col-lg-4 col-form-label">Tipo de venta<span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <select class="form-control select2" name="sale_type" id="sale_type" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="VENDEDOR" @if(old('sale_type') == "VENDEDOR") selected @endif>VENDEDOR</option>
                                    <option value="DIRECTA" @if(old('sale_type') == "DIRECTA") selected @endif>DIRECTA</option>
                                </select>
                                {!! $errors->first('sale_type', '<small class="help-block text-danger">:message</small>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Cantidad <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" id="quantity" name="quantity" value="{{ old('quantity') }}">
                                {!! $errors->first('quantity', '<small class="help-block text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        <div class="form-group row" id="vendedor_show" style="@if((old('sale_type') == "DIRECTA" || old('sale_type') == NULL) && (old('movement_type') != "DEVOLUCIÓN" || old('movement_type') == NULL)) display: none; @endif">
                            <label class="col-lg-4 col-form-label">Vendedor<span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <select class="form-control select2" name="vendedor_id" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($vendedores as $vendedor)
                                        <option value="{{ $vendedor->id }}" @if(old('vendedor_id') == $vendedor->id) selected @endif>
                                            {{ $vendedor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('vendedor_id', '<small class="help-block text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                              <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Detalle producto</h4>
                </div>
                <div class="panel-body">
                    <form action="" id="showform">
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="label-control">Producto</label>
                                <input class="form-control no-border" type="text" id="product_show" name="product_show" value="{{ old('product_show') }}" style="font-weight: bold;" />
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">SKU</label>
                                <input class="form-control no-border" type="text" id="sku_show" name="sku_show" value="{{ old('sku_show') }}" style="font-weight: bold;" />
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Marca</label>
                                <input class="form-control no-border" type="text" id="brand_show" name="brand_show" value="{{ old('brand_show') }}" style="font-weight: bold;" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="label-control">Color</label>
                                <input class="form-control no-border" type="text" id="color_show" name="color_show" value="{{ old('color_show') }}" style="font-weight: bold;" />
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Talla</label>
                                <input class="form-control no-border" type="text" id="talla_show" name="talla_show" value="{{ old('talla_show') }}" style="font-weight: bold;" />
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Género</label>
                                <input class="form-control no-border" type="text" id="gender_show" name="gender_show" value="{{ old('gender_show') }}" style="font-weight: bold;" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="label-control">Precio de compra</label>
                                <input class="form-control no-border" type="text" id="purchase_price_show" name="purchase_price_show" value="{{ old('purchase_price_show') }}" style="font-weight: bold;" />
                                <br>
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Precio de vendedor</label>
                                <input class="form-control no-border" type="text" id="selling_price_show" name="selling_price_show" value="{{ old('selling_price_show') }}" style="font-weight: bold;" />
                                <br>
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Precio de cliente</label>
                                <input class="form-control no-border" type="text" id="customer_price_show" name="customer_price_show" value="{{ old('customer_price_show') }}" style="font-weight: bold;" />
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="label-control">En existencia</label>
                                <input class="form-control no-border" type="text" id="stock_show" name="stock_show" value="{{ old('stock_show') }}" style="font-weight: bold;" />
                                <br>
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Descripción</label>
                                <textarea class="form-control no-border" id="description_show" name="description_show" rows="4" autocomplete="off" style="font-weight: bold;">{{ old('description_show') }}</textarea>
                            </div>
                            <div class="col-lg-4">
                                <label class="label-control">Imagen</label>
                                <div id="div_path_image"></div>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Inventario del sistema</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table style="width:100%;" class="table table-striped" id="tabla">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Imagen</th>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 20%;">SKU</th>
                            <th style="width: 20%;">Descripción</th>
                            <th style="width: 20%;">Marca</th>
                            <th style="width: 20%;">Color</th>
                            <th style="width: 20%;">Talla</th>
                            <th style="width: 20%;">Género</th>
                            <th style="width: 20%;">Precio de compra</th>
                            <th style="width: 20%;">Precio de vendedor</th>
                            <th style="width: 20%;">Precio de cliente</th>
                            <th style="width: 20%;">En existencia</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection