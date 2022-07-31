@extends('layouts.master')

@section('page-header')
    Gestor de colores
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
            <h4 class="panel-title">{{ $action == 'create'?'Registrar':'Editar' }} color</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create'?route('colores.store'):route('colores.update',$color->id) }}" method="post">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Color <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="color" name="color" value="{{ old('color',$color->color) }}">
                        {!! $errors->first('color', '<small class="help-block text-danger">:message</small>')!!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create'?'Registrar':'Actualizar' }}
                        </button>
                        <a href="{{ route('colores.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection