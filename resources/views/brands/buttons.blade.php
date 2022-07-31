<a href="{{ route('marcas.edit', $row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
<button href="#" class="btn btn-danger btn-sm eliminar">
	<input class="action" type="hidden" value="{{ route('marcas.destroy', $row->id) }}">
	<input class="brand" type="hidden" value="{{ $row->brand }}">
	<i class="fas fa-trash"></i> Eliminar
</button>