@extends('layouts.app')
@section('content')
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark border-bottom border-primary border-3 pb-2">Panel de Control</h2>
    </div>
    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white h-100" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1" style="letter-spacing: 1px;">Mascotas Registradas</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $petsCount }}</h2>
                    </div>
                </div>
                <a href="/pets" class="card-footer text-white text-decoration-none bg-primary bg-opacity-25 border-0 text-center py-2">
                    Administrar Mascotas →
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white h-100" style="background: linear-gradient(135deg, #198754, #157347);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1" style="letter-spacing: 1px;">Dueños Activos</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $ownersCount }}</h2>
                    </div>
                </div>
                <a href="/owners" class="card-footer text-white text-decoration-none bg-success bg-opacity-25 border-0 text-center py-2">
                    Administrar Dueños →
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-dark h-100" style="background: linear-gradient(135deg, #ffc107, #ffca2c);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1 fw-bold" style="letter-spacing: 1px;">Citas Pendientes</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $appointmentsCount }}</h2>
                    </div>
                </div>
                <a href="/appointments" class="card-footer text-dark fw-bold text-decoration-none bg-warning bg-opacity-50 border-0 text-center py-2">
                    Administrar Citas →
                </a>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4" style="overflow: visible;">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><span class="text-primary">●</span> Próximas Citas </h5>
            <span class="text-muted small">Vista rápida de agenda</span>
        </div>
        <div class="card-body p-4" style="overflow: visible;">
            <div style="overflow: visible;">
                <table class="table table-hover align-middle mb-0" style="overflow: visible;">
                    <thead class="table-light">
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Motivo / Área</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAppointments as $appointment)
                        <tr>
                            <td class="fw-bold text-secondary">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                            <td>
                                <span class="fw-bold">{{ $appointment->petRelation->name ?? 'N/A' }}</span>
                                <span class="text-muted small">({{ $appointment->petRelation->species ?? 'N/A' }})</span><br>
                                <small class="text-muted">Dueño: {{ $appointment->ownerRelation->name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <span class="text-dark fw-semibold d-block mb-1">{{ $appointment->reason }}</span>
                                @php
                                $motivoTexto = Str::lower($appointment->reason);
                                @endphp
                                @if(Str::contains($motivoTexto, ['baño', 'bano', 'pelo', 'pulgas', 'corte', 'grooming', 'estética', 'estetica', 'medicado', 'lavado']))
                                <span class="badge bg-info text-dark rounded-pill" style="font-size: 10px; font-weight: 600; padding: 4px 8px;">
                                    Aseo y Estética
                                </span>
                                @else
                                <span class="badge bg-danger text-white rounded-pill" style="font-size: 10px; font-weight: 600; padding: 4px 8px;">
                                    Consulta Médica
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($appointment->status == 'Finalizada')
                                    <span class="badge bg-dark text-white rounded-pill px-3 py-2 fw-bold shadow-sm" style="font-size: 13px;">Finalizada</span>
                                @else
                                    <div class="dropdown" style="position: relative;">
                                        @if($appointment->status == 'pendiente')
                                        <button class="btn btn-warning text-dark btn-sm dropdown-toggle px-3 py-1.5 rounded-pill fw-bold border-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Pendiente
                                        </button>
                                        @elseif($appointment->status == 'confirmada')
                                        <button class="btn btn-secondary text-white btn-sm dropdown-toggle px-3 py-1.5 rounded-pill fw-bold border-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Confirmada
                                        </button>
                                        @elseif($appointment->status == 'en_atencion')
                                        <button class="btn btn-primary text-white btn-sm dropdown-toggle px-3 py-1.5 rounded-pill fw-bold border-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            En atención
                                        </button>
                                        @elseif($appointment->status == 'completado' || $appointment->status == 'finalizado' || $appointment->status == 'listo')
                                        <button class="btn btn-success text-white btn-sm dropdown-toggle px-3 py-1.5 rounded-pill fw-bold border-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Listo para recoger
                                        </button>
                                        @else
                                        <button class="btn btn-dark text-white btn-sm dropdown-toggle px-3 py-1.5 rounded-pill fw-bold border-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ ucfirst($appointment->status) }}
                                        </button>
                                        @endif

                                        <ul class="dropdown-menu shadow border-0 rounded-3 mt-1" style="font-size: 14px; z-index: 1050; position: absolute;">
                                            <li>
                                                <h6 class="dropdown-header small text-muted fw-bold">Actualizar estado:</h6>
                                            </li>
                                            <li>
                                                <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="pendiente">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2">Pendiente</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="en_atencion">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2">En atención</button>
                                                </form>
                                            </li>
                                            <li>
                                                <div class="px-3 py-2 text-center">
                                                    <a href="/sales/create/{{ $appointment->id }}" class="btn btn-success btn-sm rounded-pill text-white px-3 fw-bold w-100">
                                                        Listo para recoger
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider my-1">
                                            </li>
                                            <li>
                                                <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelado">
                                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 fw-semibold">Cancelar Cita</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay citas programadas para el día de hoy.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection