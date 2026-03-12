<h1>Nueva Venta</h1>

<form action="/ventas" method="POST">

@csrf

<label>Cliente</label>

<select name="cliente_id">

@foreach($clientes as $cliente)

<option value="{{ $cliente->id }}">
{{ $cliente->nombre }}
</option>

@endforeach

</select>

<br><br>

<label>Producto</label>

<select name="producto_id">

@foreach($productos as $producto)

<option value="{{ $producto->id }}">
{{ $producto->nombre }} - {{ $producto->precio }}
</option>

@endforeach

</select>

<br><br>

<label>Cantidad</label>

<input type="number" name="cantidad">

<br><br>

<button type="submit">Guardar</button>

</form>