@extends('layouts.app')
@section('content')
<h1>Nueva Mascota</h1>
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
    <h5 class="mb-3">Formulario de registro</h5>
    <form action="/pets" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="form-label fw-bold">Dueño / Propietario</label>
        <select name="owner_id" class="form-select mb-3" required>
            <option value="" disabled selected>-- Seleccione el dueño de la mascota --</option>
            @foreach($owners as $owner)
                <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                    {{ $owner->name }} (Tel: {{ $owner->phone }})
                </option>
            @endforeach
        </select>
        <label class="form-label fw-bold">Nombre</label>
        <input type="text" name="name" placeholder="Nombre de la mascota" class="form-control mb-3" value="{{ old('name') }}">
        <label class="form-label fw-bold">Especie</label>
        <select name="species" class="form-select mb-3" required>
            <option value="" disabled selected>-- Seleccione una especie --</option>
            <option value="Perro" {{ old('species') == 'Perro' ? 'selected' : '' }}>Perro</option>
            <option value="Gato" {{ old('species') == 'Gato' ? 'selected' : '' }}>Gato</option>
            <option value="Conejo" {{ old('species') == 'Conejo' ? 'selected' : '' }}>Conejo</option>
            <option value="Ave" {{ old('species') == 'Ave' ? 'selected' : '' }}>Ave</option>
            <option value="Reptil" {{ old('species') == 'Reptil' ? 'selected' : '' }}>Reptil</option>
            <option value="Otro" {{ old('species') == 'Otro' ? 'selected' : '' }}>Otro / Exótico</option>
        </select>
        <label class="form-label fw-bold">Raza</label>
        <input type="text" name="breed" placeholder="Raza de la mascota" class="form-control mb-3" value="{{ old('breed') }}">
        <label class="form-label fw-bold">Edad</label>
        <input type="number" name="age" min="0" placeholder="Edad en años" class="form-control mb-3" value="{{ old('age') }}">
        <label class="form-label fw-bold">Foto de la Mascota</label>
        <input type="file" name="image" class="form-control mb-3" accept="image/*">
        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-success">Guardar Mascota</button>
            <a href="/pets" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection