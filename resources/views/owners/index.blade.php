@extends('layouts.app')
@section('content')
<h1>Dueños</h1>
<a href="/owners/create" class="btn btn-primary mb-3">
    Nuevo Dueño
</a>
<div class="card p-3">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($owners as $d)
            <tr>
                <td>{{$d->name}}</td>
                <td>{{$d->phone}}</td>
                <td>{{$d->address}}</td>
                <td>
                    <a href="/owners/{{$d->id}}/edit" class="btn btn-warning btn-sm">Editar</a>
                    <form action="/owners/{{$d->id}}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar al dueño {{ $d->name }}? ¡Se podrían desvincular sus mascotas!');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($owners->isEmpty())
    <div class="text-center py-4">
        <p class="text-muted mb-0">No hay dueños registrados aún.</p>
        <a href="/owners/create" class="btn btn-sm btn-primary mt-2">Registrar primer dueño</a>
    </div>
    @endif
</div>
@endsection