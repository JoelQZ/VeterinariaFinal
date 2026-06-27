@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        @if(session('success'))
        <div class="col-12 col-lg-10">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Logrado!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-secondary fw-bold">Inventario de Productos</h4>
                    <a href="/products/create" class="btn btn-info btn-sm rounded-pill text-white fw-bold px-4 py-2">
                        + Agregar Producto
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="fw-bold text-start ps-4">{{ $product->name }}</td>
                                <td>S/. {{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $product->stock > 5 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                        {{ $product->stock }} u.
                                    </span>
                                </td>
                                <td>
                                    @if($product->stock > 0)
                                    <span class="badge bg-info text-white rounded-pill px-2">Disponible</span>
                                    @else
                                    <span class="badge bg-secondary rounded-pill px-2">Agotado</span>
                                    @endif
                                </td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="/products/{{ $product->id }}/edit" class="btn btn-warning btn-sm rounded-pill text-white px-3">Editar</a>
                                    <form action="/products/{{ $product->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill text-white px-3" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">No hay productos registrados en el inventario.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection