<h1>Nuevo Producto</h1>

<form action="/productos" method="POST">

@csrf

<label>Nombre:</label>
<input type="text" name="nombre">
<br><br>

<label>Descripción:</label>
<input type="text" name="descripcion">
<br><br>

    <label>Precio:</label>
    <input type="text" name="precio">
<br><br>

<label>Stock:</label>
<input type="text" name="stock">

<br><br>
<label>Stock Mínimo:</label>
<input type="text" name="stock_minimo">

<br><br>

<label>Categoría:</label>

<select name="categoria_id">

@foreach($categorias as $categoria)

<option value="{{ $categoria->id }}">
{{ $categoria->nombre }}
</option>

@endforeach

</select>

<br><br>

<button type="submit">Guardar</button>

</form>