@extends('layouts.app')
@section('content')
<h1>Editar Dueño</h1>
<a href="/owners" class="btn btn-secondary mb-3">
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
    <form action="/owners/{{$owner->id}}" method="POST">
        @csrf
        @method('PUT')
        <label class="form-label fw-bold">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $owner->name) }}" class="form-control mb-3" placeholder="Nombre completo del dueño">
        <label class="form-label fw-bold">Teléfono</label>
        <input type="text"
            name="phone"
            value="{{ old('phone', $owner->phone) }}"
            class="form-control mb-3"
            placeholder="Ej: 987654321"
            maxlength="9"
            pattern="9[0-9]{8}"
            title="El teléfono debe empezar con 9 y tener exactamente 9 dígitos numéricos"
            required>
        <label class="form-label fw-bold">Dirección</label>
        <input type="text" name="address" value="{{ old('address', $owner->address) }}" class="form-control mb-3" placeholder="Dirección de residencia">
        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-primary">Actualizar</button>
            <a href="/owners" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection