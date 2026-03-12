<h1>Ventas</h1>

<a href="/ventas/create">Nueva Venta</a>

<table border="1">

<tr>
<th>ID</th>
<th>Cliente</th>
<th>Total</th>
<th>Acciones</th>
</tr>

@foreach($ventas as $venta)

<tr>

<td>{{ $venta->id }}</td>

<td>{{ $venta->cliente->nombre }}</td>

<td>{{ $venta->total }}</td>

<td>

<a href="/ventas/{{ $venta->id }}">Ver</a>

<a href="/ventas/{{ $venta->id }}/edit">Editar</a>

<form action="/ventas/{{ $venta->id }}" method="POST">

@csrf
@method('DELETE')

<button type="submit">Eliminar</button>

</form>

</td>

</tr>

@endforeach

</table>