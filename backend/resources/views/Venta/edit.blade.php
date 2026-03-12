<h1>Editar Venta</h1>

<form action="/ventas/{{ $venta->id }}" method="POST">

@csrf
@method('PUT')

<select name="cliente_id">

@foreach($clientes as $cliente)

<option value="{{ $cliente->id }}"
@if($venta->cliente_id == $cliente->id) selected @endif>

{{ $cliente->nombre }}

</option>

@endforeach

</select>

<button type="submit">Actualizar</button>

</form>