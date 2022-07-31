<ol class="breadcrumb float-xl-right">
	@php($ruta = explode('/',request()->path()))
	@foreach($ruta as $item)
	<li class="breadcrumb-item @if($loop->iteration == $loop->count) active @endif">
		<a href="#">
			@if($loop->iteration == $loop->count) <b> @endif
				@if($loop->iteration != 3 || ($loop->iteration == 3 && !is_numeric($item)))
				{{ 
					Session::get('Breadcrumbs')->contains($item) ? 
						Session::get('Breadcrumbs')->filter(function($i) use($item){ 
							return $i == $item; 
						})->flip()->first() : 
						ucfirst($item) 
				}}
				@else
					Registro
				@endif
			@if($loop->iteration == $loop->count) </b> @endif
		</a>
	</li>
	@endforeach
</ol>