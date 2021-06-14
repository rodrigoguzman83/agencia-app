@extends('layouts.plantilla')

@section('contenido')
    <h1>Eliminar región</h1>

    <div class="bg-light border-secondary col-6 mx-auto
                    shadow rounded p-4 text-danger">
        Se eliminará la región:
        <span class="lead"><mark> {{ $Region->regNombre }}</mark></span>
        <form action="/eliminarRegion" method="post">
            @csrf
            <input type="hidden" name="regNombre"
                   value="{{ $Region->regNombre }}">
            <input type="hidden" name="regID"
                   value="{{ $Region->regID }}">
            <button class="btn btn-danger btn-block my-3">
                Confirmar baja
            </button>
            <a href="/adminRegiones" class="btn btn-outline-secondary btn-block">
                Volver a panel
            </a>
        </form>
    </div>
    <script>
        Swal.fire(
            'Advertencia',
            'Si pulsa "Confirmar baja", se eliminará la región',
            'warning'
        )
    </script>

@endsection
