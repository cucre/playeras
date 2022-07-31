@extends('layouts.master')

@section('page-header')
    Gestor de usuarios
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
        $(function() {
            tabla = $('#tabla').DataTable({
                processing: true,
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
    </script>
@endpush


@section('content')
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Roles del sistema</h4>
            <div class="panel-heading-btn">
                @can('roles.edit')
                    <a href="{{ route('permisos.create') }}" class="btn btn-indigo btn-sm"><i class="fas fa-user-plus"></i>&nbsp; Agregar role</a>&nbsp;&nbsp;&nbsp;&nbsp;
                @endcan
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
                        <th style="width: 1%"></th>
                        <th style="width: 15%;">Role</th>
                        <th style="width: 15%;">Permisos Asignados</th>
                        <th style="width: 15%;">Fecha de alta</th>
                        <th style="width: 25%;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td></td>
                            <td>{{$role->name}}</td>
                            <td>
                                <ol>
                                @foreach ($role->permissions as $permission)
                                  <li> {{$permission->description}} </li>  
                                @endforeach
                                </ol>
                            </td>
                            <td>{{$role->created_at->format('d-m-Y')}}</td>
                            <td>
                                @can('roles.edit')
                                    <a href="{{ route('permisos.edit',$role->id) }}" class="btn btn-green btn-sm">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                @endcan
                                @can('roles.delete')
                                    <form action="{{ route('permisos.destroy', $role->id) }}" 
                                        style="display: inline;" method="POST">
                                        {!! method_field('DELETE') !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button title="Eliminar" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="width: 1%"></th>
                        <th style="width: 15%;">Role</th>
                        <th style="width: 15%;">Permisos Asignados</th>
                        <th style="width: 15%;">Fecha de alta</th>
                        <th style="width: 25%;">Acción</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection