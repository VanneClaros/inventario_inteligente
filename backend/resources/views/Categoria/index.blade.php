<h1>Lista de Categorías</h1>

<a href="/categorias/create">Nueva Categoría</a>

<table border="1">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Descripción</th>
<th>Acciones</th>
</tr>

@foreach($categorias as $categoria)

<tr>
<td>{{ $categoria->id }}</td>
<td>{{ $categoria->nombre }}</td>
<td>{{ $categoria->descripcion }}</td>

<td>

<a href="/categorias/{{ $categoria->id }}/edit">Editar</a>

<form action="/categorias/{{ $categoria->id }}" method="POST">
@csrf
@method('DELETE')
<button type="submit">Eliminar</button>
</form>

</td>

</tr>

@endforeach

</table>