@csrf
                
<div class="row">
    <div class="col-lg-2">
        <label class="label-control">Nombre del Rol <span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="name" name="name" value="{{ old('name',$role->name) }}">
        {!! $errors->first('name', '<small class="help-block text-danger">:message</small>')!!}
        <br>
    </div>
    <div class="col-lg-3">
        <label class="label-control">Descripción<span class="text-danger">*</span></label>
        <input class="form-control" type="text" name="description" value="{{ old('description',$role->description) }}">
        {!! $errors->first('description', '<small class="help-block text-danger">:message</small>')!!}
        <br>
    </div>
    <div class="col-lg-7">
        <label class="label-control">Permisos <span class="text-danger">*</span></label>
        <select class="form-control select2" name="permissions[]" multiple>
            @foreach($permissions as $permission)
                <option value="{{$permission->id}}" @if(in_array($permission->id,old('permissions',$role->permissions->pluck('id')->toArray()))) selected @endif>
                    {{ $permission->description }}
                </option>
            @endforeach
        </select> 
        {!! $errors->first('permissions', '<small class="help-block text-danger">:message</small>')!!}
    </div>
    
</div>
<div class="row">
    <div class="col-lg-6">
        <button class="btn btn-primary">
            <i class="fas fa-check-circle"></i>Registrar
        </button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-warning">
            <i class="fas fa-arrow-alt-circle-right fa-rotate-180"></i> Regresar
        </a>
    </div>
</div>