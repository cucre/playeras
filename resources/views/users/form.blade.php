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
            <h4 class="panel-title">{{ $action == 'create'?'Registrar':'Editar' }} usuario</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form action="{{ $action == 'create'?route('usuarios.store'):route('usuarios.update',$usuario->id) }}" method="post">
                @csrf
                @if($action == 'edit')
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Nombre <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name',$usuario->name) }}">
                        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>')!!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Apellido paterno</label>
                        <input class="form-control" type="text" id="paterno" name="paterno" value="{{ old('paterno',$usuario->paterno) }}">
                        {!! $errors->first('paterno', '<small class="help-block text-danger">:message</small>')!!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Apellido materno</label>
                        <input class="form-control" type="text" id="materno" name="materno" value="{{ old('materno',$usuario->materno) }}">
                        {!! $errors->first('materno', '<small class="help-block text-danger">:message</small>')!!}
                        <br>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="label-control">Correo electrónico <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="email" name="email" value="{{ old('email',$usuario->email) }}">
                        {!! $errors->first('email', '<small class="help-block text-danger">:message</small>')!!}
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <label class="label-control">Roles <span class="text-danger">*</span></label>
                        <select id="roles-select" class="form-control select2" name="rol">
                            <option value=""></option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}"@if(old('rol',is_null($usuario->roles->first())?null:$usuario->roles->first()->name) == $rol->name) selected @endif>
                                    {{ $rol->description }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('rol', '<small class="help-block text-danger">:message</small>')!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-check-circle"></i> {{ $action == 'create'?'Registrar':'Actualizar' }}
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection