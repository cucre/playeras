<a href="{{ route('productos.edit', $row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
<button href="#" class="btn btn-danger btn-sm eliminar">
	<input class="action" type="hidden" value="{{ route('productos.destroy', $row->id) }}">
	<input class="product" type="hidden" value="{{ $row->product }}">
	<i class="fas fa-trash"></i> Eliminar
</button>