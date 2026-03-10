<h1>Editar Cliente</h1>

<form action="/clientes/{{ $cliente->id }}" method="POST">

@csrf
@method('PUT')

<label>Nombre</label>
<input type="text" name="nombre" value="{{ $cliente->nombre }}">

<br><br>

<label>Teléfono</label>
<input type="text" name="telefono" value="{{ $cliente->telefono }}">

<br><br>

<label>Email</label>
<input type="text" name="email" value="{{ $cliente->email }}">

<br><br>

<button type="submit">Actualizar</button>

</form>