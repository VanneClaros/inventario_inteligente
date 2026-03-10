<h1>Editar Categoría</h1>

<form action="/categorias/{{ $categoria->id }}" method="POST">

@csrf
@method('PUT')

<label>Nombre:</label>

<input type="text" name="nombre" value="{{ $categoria->nombre }}">

<br><br>
<label>Descripción:</label>

<input type="text" name="descripcion" value="{{ $categoria->descripcion }}">

<br><br>

<button type="submit">Actualizar</button>

</form>