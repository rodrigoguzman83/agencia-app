@extends('layouts.plantilla')

    @section('contenido')

        <h1>Modificar región</h1>

        <div class="bg-light border-secondary col-8 mx-auto shadow rounded p-4">

            <form action="/modificarRegion" method="post">
                @csrf
                Región: <br>
                <input type="text" name="regNombre" class="form-control" value="@foreach($region as $reg){{$reg->regNombre}}@endforeach">
                <br>
                <input type="hidden" name="regID" class="form-control" value="@foreach($region as $reg){{$reg->regID}}@endforeach">
                <br>
                <button class="btn btn-primary">Modificar</button>
                <a href="/adminRegiones" class="btn btn-secondary ml-3">
                    Volver a panel
                </a>
            </form>

        </div>

    @endsection