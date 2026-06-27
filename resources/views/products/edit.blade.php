@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 bg-white rounded-4 p-4">
                <h5 class="mb-4 text-center text-warning fw-bold fs-4">Editar Producto</h5>
                <form action="/products/{{ $product->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small">Nombre del Producto</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control form-control-sm rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Precio (S/.)</label>
                        <input type="number" step="0.01" min="0" name="price" value="{{ $product->price }}" class="form-control form-control-sm rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Stock Disponible</label>
                        <input type="number" min="0" name="stock" value="{{ $product->stock }}" class="form-control form-control-sm rounded-pill" required>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="/products" class="btn btn-secondary btn-sm rounded-pill w-50 py-2 fw-bold">Cancelar</a>
                        <button type="submit" class="btn btn-warning btn-sm rounded-pill w-50 text-white fw-bold py-2">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection