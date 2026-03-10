<h1>Nuevo Cliente</h1>

<form action="/clientes" method="POST">

@csrf

<label>Nombre</label>
<input type="text" name="nombre">

<br><br>

<label>Teléfono</label>
<input type="text" name="telefono">

<br><br>

<label>Email</label>
<input type="text" name="email">

<br><br>

<button type="submit">Guardar</button>

</form>