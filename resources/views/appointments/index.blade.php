@extends('layouts.app')
@section('content')
<h1>Citas</h1>
<a href="/appointments/create" class="btn btn-primary mb-3">Nueva Cita</a>
<div class="card p-3">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Dueño</th>
                <th>Mascota</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->date }}</td>
                <td class="fw-bold text-secondary">
                    {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                </td>
                <td>{{ $appointment->ownerRelation->name ?? 'N/A' }}</td>
                <td>{{ $appointment->petRelation->name ?? 'N/A' }}</td>
                <td>{{ $appointment->reason }}</td>
                <td>
                    @if($appointment->status == 'pendiente')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pendiente</span>
                    @elseif($appointment->status == 'confirmada')
                    <span class="badge bg-secondary px-3 py-2 rounded-pill">Confirmada</span>
                    @elseif($appointment->status == 'en_atencion')
                    <span class="badge bg-success px-3 py-2 rounded-pill">En atención</span>
                    @else
                    <span class="badge bg-primary px-3 py-2 rounded-pill">{{ ucfirst($appointment->status) }}</span>
                    @endif
                </td>
                <td>
                    <a href="/appointments/{{ $appointment->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                    <form action="/appointments/{{ $appointment->id }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar cita?')">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection