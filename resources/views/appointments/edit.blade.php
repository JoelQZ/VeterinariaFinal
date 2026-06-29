@extends('layouts.app')
@section('content')
<h1>Editar Cita</h1>
<a href="/appointments" class="btn btn-secondary mb-3">
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
    <form action="/appointments/{{$appointment->id}}" method="POST">
        @csrf
        @method('PUT')
        <label class="form-label fw-bold">Dueño</label>
        <select name="owner_id" id="owner_select" class="form-select mb-3" required>
            @foreach($owners as $owner)
            <option value="{{ $owner->id }}" {{ old('owner_id', $appointment->owner_id) == $owner->id ? 'selected' : '' }}>
                {{ $owner->name }}
            </option>
            @endforeach
        </select>
        <label class="form-label fw-bold">Mascota</label>
        <select name="pet_id" id="pet_select" class="form-select mb-3" required>
            @foreach($pets as $pet)
            <option value="{{ $pet->id }}" {{ old('pet_id', $appointment->pet_id) == $pet->id ? 'selected' : '' }}>
                {{ $pet->name }}
            </option>
            @endforeach
        </select>
        <label class="form-label fw-bold">Fecha de la Cita</label>
        @php
        $currentDay = $appointment->date ? date('d', strtotime($appointment->date)) : '';
        $currentMonth = $appointment->date ? date('m', strtotime($appointment->date)) : '';
        $currentYear = $appointment->date ? date('Y', strtotime($appointment->date)) : '';
        if(intval($currentYear) < 2026) { $currentYear='2026' ; }
            @endphp
            <div class="row g-2 mb-3">
            <div class="col-4">
                <select name="appointment_day" class="form-select" required>
                    <option value="">Día</option>
                    @for ($i = 1; $i <= 31; $i++)
                        @php $val=sprintf('%02d', $i); @endphp
                        <option value="{{ $val }}" {{ old('appointment_day', $currentDay) == $val ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-4">
                <select name="appointment_month" class="form-select" required>
                    <option value="">Mes</option>
                    @foreach(['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'] as $num => $name)
                    <option value="{{ $num }}" {{ old('appointment_month', $currentMonth) == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <input type="number" name="appointment_year" value="{{ old('appointment_year', $currentYear) }}" class="form-control" min="2026" max="2100" required>
            </div>
</div>
<label class="form-label fw-bold">Hora de la Cita</label>
<input type="time" name="time" value="{{ old('time', $appointment->time) }}" class="form-control mb-3" required>
<label class="form-label fw-bold">Motivo de la Consulta</label>
<select name="reason" class="form-select mb-3" required>
    <option value="">-- Seleccione el motivo --</option>
    <option value="Consulta General Médica" {{ old('reason', $appointment->reason) == 'Consulta General Médica' ? 'selected' : '' }}> Consulta General Médica</option>
    <option value="Control de Vacunas (Séxtuple/Triple)" {{ old('reason', $appointment->reason) == 'Control de Vacunas (Séxtuple/Triple)' ? 'selected' : '' }}> Control de Vacunas (Séxtuple/Triple)</option>
    <option value="Desparasitación Interna / Externa" {{ old('reason', $appointment->reason) == 'Desparasitación Interna / Externa' ? 'selected' : '' }}> Desparasitación Interna / Externa</option>
    <option value="Baño y Corte de Pelo (Estética)" {{ old('reason', $appointment->reason) == 'Baño y Corte de Pelo (Estética)' ? 'selected' : '' }}> Baño y Corte de Pelo (Estética)</option>
    <option value="Baño Medicado Antipulgas" {{ old('reason', $appointment->reason) == 'Baño Medicado Antipulgas' ? 'selected' : '' }}> Baño Medicado Antipulgas</option>
    <option value="Esterilización / Cirugía Programada" {{ old('reason', $appointment->reason) == 'Esterilización / Cirugía Programada' ? 'selected' : '' }}> Esterilización / Cirugía Programada</option>
    <option value="Profilaxis (Limpieza Dental)" {{ old('reason', $appointment->reason) == 'Profilaxis (Limpieza Dental)' ? 'selected' : '' }}> Profilaxis (Limpieza Dental)</option>
</select>
<div class="d-flex gap-2 mt-2">
    <button class="btn btn-primary">Actualizar</button>
    <a href="/appointments" class="btn btn-secondary">Cancelar</a>
</div>
</form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ownerSelect = document.getElementById('owner_select');
        var petSelect = document.getElementById('pet_select');
        var currentPetId = "{{ $appointment->pet ?? '' }}";
        function cargarMascotas(ownerId, selectedPetId = null) {
            petSelect.innerHTML = '<option value="">-- Cargando mascotas... --</option>';
            if (ownerId) {
                fetch('/api/owners/' + ownerId + '/pets')
                    .then(response => response.json())
                    .then(data => {
                        petSelect.innerHTML = '<option value="">-- Elige una mascota --</option>';
                        if (data.length > 0) {
                            data.forEach(pet => {
                                var isSelected = (selectedPetId && pet.id == selectedPetId) ? 'selected' : '';
                                petSelect.innerHTML += `<option value="${pet.id}" ${isSelected}>${pet.name} (${pet.species})</option>`;
                            });
                        } else {
                            petSelect.innerHTML = '<option value="">Este dueño no tiene mascotas</option>';
                        }
                    });
            } else {
                petSelect.innerHTML = '<option value="">-- Elige una mascota --</option>';
            }
        }
        ownerSelect.addEventListener('change', function() {
            cargarMascotas(this.value);
        });
        if (ownerSelect.value) {
            cargarMascotas(ownerSelect.value, currentPetId);
        }
    });
</script>
@endsection