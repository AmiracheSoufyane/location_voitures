<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $car = Car::with('maintenances')->findOrFail($id);
        return view('maintenances.index',compact('car'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create(string $id)
{
    $car = Car::findOrFail($id);
    return view('maintenances.create', compact('car'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $validated = $req->validate(
        [
            'car_id' => 'required|exists:cars,id',
            'type' => 'required|string|max:255',
            'maintenance_date' => 'required|date|before_or_equal:today',
            'cost' => 'required|numeric|min:0',
            'mileage' => 'required|numeric|min:0',
        ],
        [
            'car_id.required' => 'La voiture est obligatoire',
            'car_id.exists' => 'Cette voiture n’existe pas',

            'type.required' => 'Le type de maintenance est obligatoire',

            'maintenance_date.required' => 'La date est obligatoire',
            'maintenance_date.date' => 'Format de date invalide',
            'maintenance_date.before_or_equal' => 'La date ne peut pas être dans le futur.',

            'cost.required' => 'Le coût est obligatoire',
            'cost.numeric' => 'Le coût doit être un nombre',

            'mileage.required' => 'Le kilométrage est obligatoire',
            'mileage.numeric' => 'Le kilométrage doit être un nombre',
        ]
    );
    Maintenance::create($req->all());
    $id = $req->id;
    return redirect()->route('maintenance.index', $req->car_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $car = $maintenance->car;
        return view('maintenances.edit',compact('maintenance','car'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
       $validated = $req->validate(
        [
            'car_id' => 'required|exists:cars,id',
            'type' => 'required|string|max:255',
            'maintenance_date' => 'required|date|before_or_equal:today',
            'cost' => 'required|numeric|min:0',
            'mileage' => 'required|numeric|min:0',
        ],
        [
            'car_id.required' => 'La voiture est obligatoire',
            'car_id.exists' => 'Cette voiture n’existe pas',

            'type.required' => 'Le type de maintenance est obligatoire',

            'maintenance_date.required' => 'La date est obligatoire',
            'maintenance_date.date' => 'Format de date invalide',
            'maintenance_date.before_or_equal' => 'La date ne peut pas être dans le futur.',

            'cost.required' => 'Le coût est obligatoire',
            'cost.numeric' => 'Le coût doit être un nombre',

            'mileage.required' => 'Le kilométrage est obligatoire',
            'mileage.numeric' => 'Le kilométrage doit être un nombre',
        ]
    );
    $maintenance->update($validated );
    $id = $req->id;
    return redirect()->route('maintenance.index', $req->car_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $car_id = $maintenance->car_id;
        $maintenance->delete();
        return redirect()
            ->route('maintenance.index', $car_id)
            ->with('success', '✔ Maintenance supprimée avec succès');
    }
}
