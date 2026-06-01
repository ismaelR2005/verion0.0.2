<h1>Lista de Empleados </h1>

<table border="1" cellpadding="8" >
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Puesto</th>
        <th>Correo</th>
    </tr>
    @foreach($empleados as $empleado)
    <tr>
        <td>{{ $empleado->id }}</td>
        <td>{{ $empleado->nombre }}</td>
        <td>{{ $empleado->puesto }}</td>
        <td>{{ $empleado->correo }}</td>
    </tr>
    @endforeach

    </table>

