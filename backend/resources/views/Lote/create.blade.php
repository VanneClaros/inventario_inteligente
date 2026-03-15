<h2>Registrar Lote</h2>

<a href="{{ route('lotes.index') }}">Volver</a>

<form action="{{ route('lotes.store') }}" method="POST">

@csrf

<label>Producto</label>

<select name="producto_id">

@foreach($productos as $producto)

<option value="{{ $producto->id }}">
{{ $producto->nombre }}
</option>

@endforeach

</select>

<br><br>

<label>Cantidad</label>

<input type="number" name="cantidad">

<br><br>
<label>Fecha de Ingreso</label>

<input type="date" name="fecha_ingreso">

<br><br>

<label>Fecha Vencimiento</label>

<input type="date" name="fecha_vencimiento">

<br><br>

<button type="submit">
Guardar
</button>

</form>