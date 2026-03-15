<h2>Lista de Lotes</h2>

<a href="{{ route('lotes.create') }}">Nuevo Lote</a>

<table border="1">

<tr>
    <th>ID</th>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Fecha Ingreso</th>
    <th>Fecha Vencimiento</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

@foreach($lotes as $lote)

@php
$hoy = date('Y-m-d');
@endphp

<tr>
<td>{{ $lote->id }}</td>
<td>{{ $lote->producto->nombre }}</td>
<td>{{ $lote->cantidad }}</td>
<td>{{ $lote->fecha_ingreso }}</td>
<td>{{ $lote->fecha_vencimiento }}</td>
<td>

@if($lote->fecha_vencimiento < $hoy)

<span style="color:red">Vencido</span>

@elseif($lote->fecha_vencimiento <= date('Y-m-d', strtotime('+30 days')))

<span style="color:orange">Por vencer</span>

@else

<span style="color:green">Vigente</span>

@endif

</td>

<td>

<a href="{{ route('lotes.edit',$lote->id) }}">
Editar
</a>

<form action="{{ route('lotes.destroy',$lote->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button type="submit">Eliminar</button>
</form>
</td>
</tr>
@endforeach

</table>