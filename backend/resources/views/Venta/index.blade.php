<h1>Ventas</h1>

<a href="/ventas/create">Nueva Venta</a>

<table border="1">

<tr>
<th>ID</th>
<th>Cliente</th>
<th>Total</th>
<th>Fecha</th>
<th>Acciones</th>
</tr>

@foreach($ventas as $venta)
<tr>
<td>{{ $venta->id }}</td>
<td>{{ $venta->cliente->nombre }}</td> 
<td>{{ $venta->total }}</td> 
<td>{{ $venta->fecha }}</td>
<td>
    <a href="{{ route('ventas.show', $venta->id) }}">Ver detalle</a>
    <!-- <a href="{{ route('ventas.edit', $venta->id) }}">Editar</a> -->
        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('¿Eliminar esta venta?')" type="submit">Eliminar</button>
        </form>
    </td>
</tr>
@endforeach

</table>