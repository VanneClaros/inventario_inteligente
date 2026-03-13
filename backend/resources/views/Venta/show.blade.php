<h2>Detalle de Venta</h2>

<p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
<p><strong>Fecha:</strong> {{ $venta->created_at }}</p>
<p><strong>Total:</strong> {{ $venta->total }}</p>

<table border="1">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($venta->detalles as $detalle)
        <tr>
            <td>{{ $detalle->producto->nombre }}</td>
            <td>{{ $detalle->cantidad }}</td>
            <td>{{ $detalle->precio }}</td>
            <td>{{ $detalle->cantidad * $detalle->precio }}</td>
        </tr>
        @endforeach
    </tbody>
</table>