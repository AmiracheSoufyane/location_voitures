<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class carsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
       $cars = Car::query();
       $mat = $req->mat ?? "";
        if ($mat) {
            $cars->where('registration',$mat);
        }
        $cars = $cars->paginate(10);
        return view('cars.index',compact('cars','mat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $req)
    {
        $data = $req->validate([
            'brand' => 'required|max:40',
            'model' => 'required|max:40',
            'mileage' => 'required|integer',
            'status' => 'required|in:disponible,loué,maintenance',
            'registration' => 'required|unique:cars,registration',
            'fuel_type' => 'required|in:Diesel,Essence,Hybrid,Electrique',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'brand.required' => 'Le brand est obligatoire.',
            'model.required' => 'Le modèle est obligatoire.',
            'status.required' => 'Le statut est obligatoire.',
            'mileage.required' => 'Le kilométrage est obligatoire.',
            'mileage.integer' => 'Le kilométrage doit être un nombre.',

            'registration.required' => 'La matricule est obligatoire.',
            'registration.unique' => 'Cette matricule existe déjà.',

            'fuel_type.required' => 'Le type de carburant est obligatoire.',
            'fuel_type.in' => 'Type de carburant invalide.',

            'year.required' => 'L’année est obligatoire.',
            'year.integer' => 'L’année doit être un nombre.',
            'year.min' => 'L’année doit être >= 1990.',
            'year.max' => 'L’année ne peut pas dépasser ' . date('Y') . '.',

            'price_per_day.required' => 'Le prix par jour est obligatoire.',
            'price_per_day.numeric' => 'Le prix doit être un nombre.',
            'price_per_day.min' => 'Le prix doit être positif.',

            'image.required' => 'L’image est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Formats acceptés : jpg, jpeg, png.',
            'image.max' => 'L’image ne doit pas dépasser 2MB.',

        ]);

        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('cars', $filename, 'public');
            $data['image'] = 'cars/' . $filename;
        }

        Car::create($data);

        return to_route('cars')
            ->with('success', 'Voiture ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::findOrFail($id);
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        $car = Car::findOrFail($id);
        $data = $req->validate([
            'brand' => 'required|max:40',
            'model' => 'required|max:40',
            'mileage' => 'required|integer',
            'status' => 'required|in:disponible,loué,maintenance',
            'registration' => 'required|unique:cars,registration,' . $car->id,
            'fuel_type' => 'required|in:Diesel,Essence,Hybrid,Electrique',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'brand.required' => 'La marque est obligatoire.',
            'model.required' => 'Le modèle est obligatoire.',
            'mileage.required' => 'Le kilométrage est obligatoire.',
            'mileage.integer' => 'Le kilométrage doit être un nombre.',

            'status.required' => 'Le statut est obligatoire.',

            'registration.required' => 'La matricule est obligatoire.',
            'registration.unique' => 'Cette matricule existe déjà.',

            'fuel_type.required' => 'Le type de carburant est obligatoire.',
            'fuel_type.in' => 'Type de carburant invalide.',

            'year.required' => 'L’année est obligatoire.',
            'year.integer' => 'L’année doit être un nombre.',
            'year.min' => 'L’année doit être >= 1990.',
            'year.max' => 'L’année ne peut pas dépasser ' . date('Y') . '.',

            'price_per_day.required' => 'Le prix est obligatoire.',
            'price_per_day.numeric' => 'Le prix doit être un nombre.',
            'price_per_day.min' => 'Le prix doit être positif.',

            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Formats acceptés : jpg, jpeg, png.',
            'image.max' => 'Max 2MB.',
        ]);
        if($req->hasFile('image')){
            if($car->image && Storage::disk('public')->exists($car->image)){
                Storage::disk('public')->delete($car->image);
            }
            $file = $req->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('cars', $filename, 'public');

            $data['image'] = 'cars/' . $filename;
        }
        $car->update($data);
        return to_route('cars')
        ->with('success', 'Voiture modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);
        if ($car->image && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return to_route('cars')->with('success', 'Voiture supprimée avec succès');
    }
}
