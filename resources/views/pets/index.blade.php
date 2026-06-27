@extends('layouts.app')
@section('content')
<h1>Mascotas</h1>
<a href="/pets/create" class="btn btn-primary mb-3">
    Nueva Mascota
</a>
<div class="card p-3">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Dueño</th> <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pets as $m)
            <tr>
                <td>
                    @if($m->image)
                        <img src="{{ asset('storage/' . $m->image) }}" alt="Foto" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <span class="badge bg-secondary">Sin foto</span>
                    @endif
                </td>
                <td>{{$m->name}}</td>
                
                <td>
                    @if($m->owner)
                        <span class="fw-bold text-primary">{{ $m->owner->name }}</span>
                    @else
                        <span class="text-muted">Sin dueño</span>
                    @endif
                </td>
                
                <td>{{$m->species}}</td>
                <td>{{$m->breed}}</td>
                <td>{{$m->age}} años</td>
                <td>
                    <a href="/pets/{{$m->id}}/edit" class="btn btn-warning btn-sm">
                        Editar
                    </a>
                    
                    <form action="/pets/{{$m->id}}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a {{ $m->name }}?');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($pets->isEmpty())
    <div class="text-center py-4">
        <p class="text-muted mb-0">No hay mascotas registradas aún.</p>
        <a href="/pets/create" class="btn btn-sm btn-primary mt-2">Registrar primera mascota</a>
    </div>
    @endif
</div>
@endsection