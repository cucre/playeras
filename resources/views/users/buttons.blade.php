<a href="{{ route('usuarios.edit',$row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
<button href="#" class="btn btn-danger btn-sm eliminar">
	<input class="action" type="hidden" value="{{ route('usuarios.destroy',$row->id) }}">
	<input class="user" type="hidden" value="{{ $row->full_name }}">
	<i class="fas fa-trash"></i> Eliminar
</button>