@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark border-bottom border-primary border-3 pb-2">Historial de Ventas y Caja</h2>
    </div>
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-start border-success border-4">
                <span class="text-muted small fw-bold text-uppercase">Efectivo</span>
                <h4 class="fw-bold text-success mb-0">S/. {{ number_format($totalEfectivo, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-start border-primary border-4">
                <span class="text-muted small fw-bold text-uppercase">Tarjeta</span>
                <h4 class="fw-bold text-primary mb-0">S/. {{ number_format($totalTarjeta, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-start border-info border-4">
                <span class="text-muted small fw-bold text-uppercase">Transferencias / Yape</span>
                <h4 class="fw-bold text-info mb-0">S/. {{ number_format($totalTransferencia, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-white p-3" style="background: linear-gradient(135deg, #212529, #343a40);">
                <span class="text-light opacity-75 small fw-bold text-uppercase">Total en Caja</span>
                <h4 class="fw-bold mb-0">S/. {{ number_format($totalGeneral, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Cliente / Dueño</th>
                            <th>Método Pago</th>
                            <th>Conceptos / Detalles</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="text-secondary small">{{ $sale->created_at->format('d/m/Y h:i A') }}</td>
                            <td class="fw-bold text-dark">{{ $sale->owner->name ?? 'Cliente General' }}</td>
                            <td>
                                @if($sale->payment_method == 'Efectivo')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Efectivo</span>
                                @elseif($sale->payment_method == 'Tarjeta')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">Tarjeta</span>
                                @else
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">Transferencia</span>
                                @endif
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($sale->details as $detail)
                                        <li class="text-muted">
                                            • {{ $detail->concept }} <span class="fw-bold text-dark">({{ $detail->quantity }}x S/. {{ number_format($detail->price, 2) }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-end fw-bold text-dark" style="font-size: 16px;">S/. {{ number_format($sale->total, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aún no se han registrado ventas el día de hoy.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection