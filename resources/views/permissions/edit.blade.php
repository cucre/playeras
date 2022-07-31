@extends('layouts.master')

@section('page-header')
    Gestor de usuarios
@endsection

@push('customjs')
    <script type="text/javascript">
        
        $(document).ready(function(){
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
            <h4 class="panel-title">Editar Rol</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ route('permisos.update',$role->id) }}" method="post">
                @csrf
                {!! method_field('PUT') !!}
                @include('permissions.form')
            </form>
        </div>
    </div>
@endsection