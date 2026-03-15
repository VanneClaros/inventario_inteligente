<h2>Editar Lote</h2>

<a href="{{ route('lotes.index') }}">Volver</a>

<form action="{{ route('lotes.update',$lote->id) }}" method="POST">

@csrf
@method('PUT')

<label>Producto</label>

<select name="producto_id">

@foreach($productos as $producto)

<option value="{{ $producto->id }}"
@if($producto->id == $lote->producto_id) selected @endif>

{{ $producto->nombre }}

</option>

@endforeach

</select>

<br><br>

<label>Cantidad</label>

<input type="number" name="cantidad" value="{{ $lote->cantidad }}">

<br><br>
<label>Fecha de Ingreso</label>

<input type="date" name="fecha_ingreso" value="{{ $lote->fecha_ingreso }}">

<br><br>
<label>Fecha Vencimiento</label>

<input type="date" name="fecha_vencimiento" value="{{ $lote->fecha_vencimiento }}">

<br><br>

<button type="submit">
Actualizar
</button>

</form>