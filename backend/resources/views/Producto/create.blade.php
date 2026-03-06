<a href="/productos/create">Nuevo Producto</a>
<h1>Registrar Producto</h1>

<form action="/productos" method="POST">
    @csrf

    <label>Nombre</label>
    <input type="text" name="nombre">

    <br><br>
    <label>Descripcion</label>
    <input type="text" name="descripcion">

    <br><br>
    <label>Precio</label>
    <input type="number" name="precio">

    <br><br>
    <label>Stock</label>
    <input type="number" name="stock">
    <br><br>
    <button type="submit">Guardar</button>
</form>