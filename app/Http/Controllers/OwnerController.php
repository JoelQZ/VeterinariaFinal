<?php
namespace App\Http\Controllers;
use App\Models\Owner;
use Illuminate\Http\Request;
class OwnerController extends Controller{
    public function index(){
        $owners = Owner::all();
        return view('owners.index', compact('owners'));
    }

    public function create(){
        return view('owners.create');
    }

    public function store(Request $request){
    $request->validate([
            'name' => 'required',
            'phone' => ['required', 'numeric', 'regex:/^9[0-9]{8}$/'],
            'address' => 'required'
        ], [
            'phone.regex' => 'El teléfono debe comenzar obligatoriamente con el número 9 y tener exactamente 9 dígitos.',
            'phone.numeric' => 'El teléfono solo debe contener números.',
        ]);
        Owner::create($request->all());
        return redirect('/owners')->with('Exito', 'Dueño Registrado');
    }

    public function edit(Owner $owner){
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner) {
    $request->validate([
            'name' => 'required',
            'phone' => ['required', 'numeric', 'regex:/^9[0-9]{8}$/'],
            'address' => 'required'
        ], [
            'phone.regex' => 'El teléfono debe comenzar obligatoriamente con el número 9 y tener exactamente 9 dígitos.',
            'phone.numeric' => 'El teléfono solo debe contener números.',
        ]);
        $owner->update($request->all());
        return redirect('/owners')->with('Exito', 'Dueño Actualizado');
    }

    public function destroy(Owner $owner){
        $owner->delete();
        return redirect('/owners')->with('Exito','Dueño Eliminado');
    }
}