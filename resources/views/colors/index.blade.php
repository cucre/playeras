@extends('layouts.master')

@section('page-header')
    Gestor de colores
@endsection

@push('customcss')
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
    <script>
        var tabla;
        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('colores.data') !!}',
                columns: [
                    { data: 'color', name: 'color'},
                    { data: 'accion', name: 'accion', className: 'text-center' },
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
        });

        $(document).on('click',".eliminar",function(){
            $("#color_name").text($(this).find('.color').val());
            $("#modal-form").prop('action',$(this).find('.action').val());
            $("#delModal").modal('show');
        });
    </script>
@endpush


@section('content')
    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModal" aria-hidden="true">
        <form id="modal-form" method="post">
            @csrf
            {!! method_field('DELETE') !!}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="delModalLabel">¿Eliminar color?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 text-center">
                            <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
                        </div>
                        <div class="col-lg-12 text-center">
                            ¿Estás seguro que quieres eliminar el color <b id="color_name"></b>?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Colores del sistema</h4>
            <div class="panel-heading-btn">
                <a href="{{ route('colores.create') }}" class="btn btn-indigo btn-sm"><i class="fas fa-plus-circle"></i>&nbsp; Agregar color</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <table width="100%" class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th style="width: 20%;">Nombre</th>
                        <th style="width: 15%;">Acción</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection