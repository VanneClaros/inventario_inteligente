<h1>Crear Producto</h1>

<form action="/productos" method="POST">
    @csrf

    <label>Nombre:</label>
    <input type="text" name="nombre">

    <button type="submit">Guardar</button>
</form>