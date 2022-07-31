<a href="{{ route('tallas.edit',$row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
<button href="#" class="btn btn-danger btn-sm eliminar">
	<input class="action" type="hidden" value="{{ route('tallas.destroy',$row->id) }}">
	<input class="talla" type="hidden" value="{{ $row->talla }}">
	<i class="fas fa-trash"></i> Eliminar
</button>