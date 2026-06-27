@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 bg-white rounded-4 p-4">
                <h4 class="mb-4 text-secondary fw-bold text-center">Registrar Cobro y Finalizar Cita</h4>
                <form action="/sales" method="POST">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="owner_id" value="{{ $appointment->ownerRelation->id ?? $appointment->owner }}">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <h5 class="text-info fw-bold mb-3">Resumen del Servicio</h5>
                                <p class="mb-1"><strong>Paciente:</strong> {{ $appointment->petRelation->name ?? 'No asignado' }}</p>
                                <p class="mb-1"><strong>Dueño:</strong> {{ $appointment->ownerRelation->name ?? 'No asignado' }}</p>
                                <p class="mb-3"><strong>Motivo:</strong> {{ $appointment->reason }}</p>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label small text-secondary fw-bold">Costo del Servicio (S/.)</label>
                                    <input type="number" step="0.01" min="0" name="service_price" class="form-control rounded-pill" required placeholder="Ej: 35.00">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-secondary fw-bold">Método de Pago</label>
                                    <select name="payment_method" class="form-select rounded-pill" required>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Tarjeta">Tarjeta Débito/Crédito</option>
                                        <option value="Transferencia">Transferencia / Yape / Plin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <h5 class="text-info fw-bold mb-3">¿Lleva algún producto del Inventario?</h5>
                                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                    <table class="table table-sm align-middle text-center bg-white rounded-3 overflow-hidden">
                                        <thead class="table-dark small">
                                            <tr>
                                                <th>¿Lleva?</th>
                                                <th class="text-start">Producto</th>
                                                <th>Precio</th>
                                                <th>Stock</th>
                                                <th style="width: 80px;">Cant.</th>
                                            </tr>
                                        </thead>
                                        <tbody class="small">
                                            @forelse($products as $product)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="products[{{ $product->id }}][selected]" value="1" class="form-check-input">
                                                </td>
                                                <td class="text-start fw-bold">{{ $product->name }}</td>
                                                <td>S/. {{ number_format($product->price, 2) }}</td>
                                                <td><span class="badge bg-secondary rounded-pill">{{ $product->stock }} u.</span></td>
                                                <td>
                                                    <input type="number" name="products[{{ $product->id }}][quantity]" value="1" min="1" max="{{ $product->stock }}" class="form-control form-control-sm text-center rounded-pill p-1">
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-muted py-3">No hay productos disponibles en el inventario.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="/dashboard" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold">Cancelar</a>
                        <button type="submit" class="btn btn-success rounded-pill px-5 py-2 fw-bold text-white">Procesar Pago y Cerrar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection