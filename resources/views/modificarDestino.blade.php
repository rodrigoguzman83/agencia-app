@extends('layouts.plantilla')
    @section('contenido')

        <h1>Modificar destino</h1>

        <div class="bg-light border-secondary col-8 mx-auto shadow rounded p-4">

        <form action="/modificarDestino" method="post">
            @csrf
            Nombre: <br>
            <input type="text" name="destNombre" class="form-control" value="{{$Destino->destNombre}}" required>
            <br>
            Región: <br>
            <select name="regID" class="form-control" required>
                <option value="">Seleccione una region</option>
                @foreach($regiones as $region)
                <option {{ ($Destino->regID == $region->regID)?'selected':'' }} value="{{ $region->regID }}">{{ $region->regNombre }}</option>
                @endforeach
            </select>
            <br>
            
            Precio: <br>
            <input type="number" name="destPrecio" class="form-control" value="{{$Destino->destPrecio}}" required>
            <br>
            Asientos Totales: <br>
            <input type="number" name="destAsientos" class="form-control" value="{{$Destino->destAsientos}}" required>
            <br>
            Asientos Disponibles: <br>
            <input type="number" name="destDisponibles" class="form-control" value="{{$Destino->destDisponibles}}" required>
            <br>
            <input type="hidden" name="destID" value="{{ $Destino->destID }}">
            <button class="btn btn-primary">Agregar</button>
            <a href="/adminDestinos" class="btn btn-outline-secondary ml-3">
                 Volver a panel
            </a>
        </form>

        </div>

    @endsection