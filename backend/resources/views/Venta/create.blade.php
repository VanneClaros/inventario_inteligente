<h2>Nueva Venta</h2>

<form action="{{ route('ventas.store') }}" method="POST">

@csrf

<label>Cliente</label>

<select name="cliente_id">

@foreach($clientes as $cliente)

<option value="{{$cliente->id}}">
{{$cliente->nombre}}
</option>

@endforeach

</select>

<br><br>

<label>Fecha</label>

<input type="date" name="fecha" value="{{date('Y-m-d')}}">

<br><br>

<label>Producto</label>

<select id="producto">

@foreach($productos as $producto)

<option 
value="{{$producto->id}}" 
data-precio="{{$producto->precio}}">

{{$producto->nombre}}

</option>

@endforeach

</select>

<label>Cantidad</label>

<input type="number" id="cantidad" min="1">

<button type="button" onclick="agregarProducto()">
Agregar al carrito
</button>

<br><br>

<h3>Productos de la venta</h3>

<table border="1">

<thead>

<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Subtotal</th>
<th>Acción</th>
</tr>

</thead>

<tbody id="tablaProductos"></tbody>

</table>

<h3>Total: Bs <span id="total">0</span></h3>

<br>

<button type="submit">
Guardar Venta
</button>

</form>


<script>

let carrito = []
let total = 0

function agregarProducto(){

let productoSelect = document.getElementById("producto")
let producto_id = productoSelect.value
let nombre = productoSelect.options[productoSelect.selectedIndex].text
let precio = parseFloat(productoSelect.options[productoSelect.selectedIndex].dataset.precio)

let cantidad = document.getElementById("cantidad").value

if(cantidad == "" || cantidad <= 0){

alert("Ingrese cantidad")

return

}

let subtotal = precio * cantidad

carrito.push({
producto_id,
nombre,
precio,
cantidad,
subtotal
})

total += subtotal

renderCarrito()

}


function renderCarrito(){

let tabla = document.getElementById("tablaProductos")

tabla.innerHTML = ""

carrito.forEach((item,index)=>{

tabla.innerHTML += `

<tr>

<td>${item.nombre}</td>
<td>${item.cantidad}</td>
<td>${item.precio}</td>
<td>${item.subtotal}</td>

<td>

<button type="button" onclick="eliminar(${index})">
Eliminar
</button>

</td>

<input type="hidden" name="productos[]" value="${item.producto_id}">
<input type="hidden" name="cantidades[]" value="${item.cantidad}">

</tr>

`

})

document.getElementById("total").innerText = total

}


function eliminar(index){

total -= carrito[index].subtotal

carrito.splice(index,1)

renderCarrito()

}

</script>