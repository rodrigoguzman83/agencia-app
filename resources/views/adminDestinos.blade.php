@extends('layouts.plantilla')

    @section('contenido')

        <h1>Panel de administración de destinos</h1>


        <table class="table table-borderless table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Destino</th>
                    <th colspan="2">
                        <a href="/agregarDestino" class="btn btn-outline-primary">
                            Agregar
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach( $destinos as $destino )
                <tr>
                    <td>{{ $destino->destID }}</td>
                    <td>{{ $destino->destNombre }}</td>
                    <td>
                        <a href="/modificarDestino/destID" class="btn btn-outline-secondary">
                            Modificar
                        </a>
                    </td>
                    <td>
                        <a href="/eliminarDestino/destID" class="btn btn-outline-danger">
                            Eliminar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    @endsection
