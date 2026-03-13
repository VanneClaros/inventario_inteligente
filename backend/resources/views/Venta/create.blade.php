<h2>Nueva Venta</h2>

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

<select id="producto">

@foreach($productos as $producto)

<option value="{{ $producto->id }}"
data-precio="{{ $producto->precio }}">

{{ $producto->nombre }} - {{ $producto->precio }}

</option>

@endforeach

</select>

<br><br>

<label>Cantidad</label>

<input type="number" id="cantidad" min="1">

<br><br>

<button type="button" onclick="agregarProducto()">
Agregar al carrito
</button>

<br><br>

<h3>Productos de la venta</h3>

<table border="1" id="tabla">

<thead>

<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Subtotal</th>
</tr>

</thead>

<tbody>
</tbody>

</table>

<br>

<h3>Total: <span id="total">0</span></h3>

<br>

<button type="submit">
Guardar venta
</button>

<script>
let total = 0;

function agregarProducto() {
    let producto = document.getElementById("producto");
    let producto_id = producto.value;
    let nombre = producto.options[producto.selectedIndex].text;
    let precio = producto.options[producto.selectedIndex].dataset.precio;
    let cantidad = document.getElementById("cantidad").value;

    if (cantidad <= 0) {
        alert("Ingrese una cantidad válida");
        return;
    }

    let subtotal = precio * cantidad;
    total = parseFloat(total) + parseFloat(subtotal);
    document.getElementById("total").innerText = total;

    let tabla = document.querySelector("#tabla tbody");

    let fila = `
        <tr>
            <td>${nombre}
                <input type="hidden" name="productos[]" value="${producto_id}">
            </td>
            <td>${cantidad}
                <input type="hidden" name="cantidades[]" value="${cantidad}">
            </td>
            <td>${precio}
                <input type="hidden" name="precios[]" value="${precio}">
            </td>
            <td>${subtotal}</td>
        </tr>
    `;

    tabla.innerHTML += fila;
}
</script>
</from>
