<?php
namespace App\Http\Controllers;
use App\Models\Pet;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PetController extends Controller{
    public function index(){
        $pets = Pet::with('owner')->get();
        return view('pets.index', compact('pets'));
    }

    public function create(){
        $owners = Owner::all();
        return view('pets.create', compact('owners'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'species' => 'required',
            'breed' => 'required',
            'age' => 'required|integer|min:0',
            'owner_id' => 'required|exists:owners,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pets', 'public');
            $data['image'] = $path;
        }
        Pet::create($data);
        return redirect('/pets')->with('Exito', 'Mascota Registrada');
    }

    public function edit(Pet $pet){
        $owners = Owner::all();
        return view('pets.edit', compact('pet', 'owners'));
    }

    public function update(Request $request, Pet $pet){
        $request->validate([
            'name' => 'required',
            'species' => 'required',
            'breed' => 'required',
            'age' => 'required|integer|min:0',
            'owner_id' => 'required|exists:owners,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($pet->image && Storage::disk('public')->exists($pet->image)) {
                Storage::disk('public')->delete($pet->image);
            }
            $path = $request->file('image')->store('pets', 'public');
            $data['image'] = $path;
        }
        $pet->update($data);
        return redirect('/pets')->with('Exito', 'Mascota Actualizada');
    }

    public function destroy(Pet $pet){
        if ($pet->appointments()->exists()) {
            $pet->appointments()->delete(); 
        }

        if ($pet->image && Storage::disk('public')->exists($pet->image)) {
            Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();
        return redirect('/pets')->with('Exito', 'Mascota Eliminada');
    }
}