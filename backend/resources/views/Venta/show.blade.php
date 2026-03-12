<h1>Detalle Venta</h1>

Cliente: {{ $venta->cliente->nombre }}

<table border="1">

<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Precio</th>
</tr>

@foreach($venta->detalles as $detalle)

<tr>
<td>{{ $detalle->producto->nombre }}</td>
<td>{{ $detalle->cantidad }}</td>
<td>{{ $detalle->precio }}</td>
</tr>

@endforeach

</table>

Total: {{ $venta->total }}