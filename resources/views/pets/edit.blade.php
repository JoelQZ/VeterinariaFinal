@extends('layouts.app')
@section('content')
<h1>Editar Mascota</h1>
<a href="/pets" class="btn btn-secondary mb-3">
    ← Volver al listado
</a>
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card p-4">
    <h5 class="mb-3">Formulario de edición</h5>
    <form action="/pets/{{$pet->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <label class="form-label fw-bold">Dueño / Propietario</label>
        <select name="owner_id" class="form-select mb-3" required>
            @foreach($owners as $owner)
                <option value="{{ $owner->id }}" {{ old('owner_id', $pet->owner_id) == $owner->id ? 'selected' : '' }}>
                    {{ $owner->name }}
                </option>
            @endforeach
        </select>

        <label class="form-label fw-bold">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $pet->name) }}" class="form-control mb-3" placeholder="Nombre de la mascota">
        
        <label class="form-label fw-bold">Especie</label>
        <select name="species" class="form-select mb-3" required>
            <option value="Perro" {{ old('species', $pet->species) == 'Perro' ? 'selected' : '' }}>Perro</option>
            <option value="Gato" {{ old('species', $pet->species) == 'Gato' ? 'selected' : '' }}>Gato</option>
            <option value="Conejo" {{ old('species', $pet->species) == 'Conejo' ? 'selected' : '' }}>Conejo</option>
            <option value="Ave" {{ old('species', $pet->species) == 'Ave' ? 'selected' : '' }}>Ave</option>
            <option value="Reptil" {{ old('species', $pet->species) == 'Reptil' ? 'selected' : '' }}>Reptil</option>
            <option value="Otro" {{ old('species', $pet->species) == 'Otro' ? 'selected' : '' }}>Otro / Exótico</option>
        </select>
        
        <label class="form-label fw-bold">Raza</label>
        <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}" class="form-control mb-3" placeholder="Raza de la mascota">
        
        <label class="form-label fw-bold">Edad</label>
        <input type="number" name="age" min="0" value="{{ old('age', $pet->age) }}" class="form-control mb-3" placeholder="Edad en años">
        
        <label class="form-label fw-bold">Foto de la Mascota</label>
        @if($pet->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $pet->image) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                <span class="text-muted ms-2" style="font-size: 0.85rem;">(Imagen actual)</span>
            </div>
        @endif
        <input type="file" name="image" class="form-control mb-3" accept="image/*">
        
        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-primary">Actualizar Mascota</button>
            <a href="/pets" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection