<h1>Clientes</h1>

<a href="/clientes/create">Nuevo Cliente</a>

<table border="1">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Teléfono</th>
<th>Email</th>
<th>Acciones</th>
</tr>

@foreach($clientes as $cliente)

<tr>
<td>{{ $cliente->id }}</td>
<td>{{ $cliente->nombre }}</td>
<td>{{ $cliente->telefono }}</td>
<td>{{ $cliente->email }}</td>

<td>
<a href="/clientes/{{ $cliente->id }}/edit">Editar</a>
</td>

</tr>

@endforeach

</table>