<a href="{{ route('colores.edit',$row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
<button href="#" class="btn btn-danger btn-sm eliminar">
	<input class="action" type="hidden" value="{{ route('colores.destroy',$row->id) }}">
	<input class="color" type="hidden" value="{{ $row->color }}">
	<i class="fas fa-trash"></i> Eliminar
</button>