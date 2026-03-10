<h1>Nueva Categoría</h1>

<form action="/categorias" method="POST">

@csrf

<label>Nombre de la categoría:</label>

<input type="text" name="nombre">

<br><br>
<label>Descripción de la categoría:</label>

<input type="text" name="descripcion">

<br><br>

<button type="submit">Guardar</button>

</form>