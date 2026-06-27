<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Owner;
use Illuminate\Http\Request;
class AppointmentController extends Controller{
    public function index(){
        $appointments = Appointment::with(['petRelation', 'ownerRelation'])->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create(){
        $owners = Owner::all();
        return view('appointments.create', compact('owners'));
    }

    public function getPetsByOwner($ownerId){
        $pets = \App\Models\Pet::where('owner_id', $ownerId)->get();
        return response()->json($pets);
    }

    public function store(Request $request){
        $request->validate([
            'owner_id' => 'required',
            'pet_id' => 'required',
            'reason' => 'required',
            'appointment_day' => 'required',
            'appointment_month' => 'required',
            'appointment_year' => 'required',
            'time' => 'required',
        ]);
        Appointment::create([
            'owner' => $request->owner_id,
            'pet' => $request->pet_id,
            'reason' => $request->reason,
            'date' => $request->appointment_year . '-' . $request->appointment_month . '-' . $request->appointment_day,
            'time' => $request->time
        ]);
        return redirect('/appointments')->with('Exito', 'Cita Registrada');
    }

    public function edit(Appointment $appointment){
        $owners = Owner::all();
        $pets = Pet::where('owner_id', $appointment->owner_id)->get();
        return view('appointments.edit', compact('appointment', 'pets', 'owners'));
    }

    public function update(Request $request, Appointment $appointment){
        $request->validate([
            'owner_id' => 'required',
            'pet_id' => 'required',
            'reason' => 'required',
            'appointment_day' => 'required',
            'appointment_month' => 'required',
            'appointment_year' => 'required',
            'time' => 'required',
        ]);
        $appointment->update([
            'owner' => $request->owner_id,
            'pet' => $request->pet_id,
            'reason' => $request->reason,
            'date' => $request->appointment_year . '-' . $request->appointment_month . '-' . $request->appointment_day,
            'time' => $request->time
        ]);
        return redirect('/appointments')->with('Exito', 'Cita Actualizada');
    }

    public function destroy(Appointment $appointment){
        $appointment->delete();
        return redirect('/appointments')->with('Exito', 'Cita Eliminada');
    }

    public function updateStatus(Request $request, Appointment $appointment){
        $request->validate([
            'status' => 'required|string',
        ]);
        $appointment->status = $request->status;
        $appointment->save();
        
        return back()->with('success', 'Estado de la cita actualizado');
    }
}