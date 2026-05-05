<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Models\Notification;

class MaintenancesController extends Controller
{
    /**
     * Afficher la liste des maintenances d’une voiture
     */
    public function index(string $id)
    {
        $car = Car::with('maintenances')->findOrFail($id);
        return view('maintenances.index', compact('car'));
    }

    /**
     * Afficher le formulaire de création d’une maintenance
     */
    public function create(string $id)
    {
        $car = Car::findOrFail($id);
        return view('maintenances.create', compact('car'));
    }

    /**
     * Enregistrer une nouvelle maintenance
     */
    public function store(Request $req)
    {
        $validated = $req->validate([
            'car_id' => 'required|exists:cars,id',
            'type' => 'required|string|max:255',
            'maintenance_date' => 'required|date|before_or_equal:today',
            'cost' => 'required|numeric|min:0',
            'mileage' => 'required|numeric|min:0',
        ]);

        $data = $req->only(['car_id', 'type', 'maintenance_date', 'cost', 'mileage']);

        if ($req->has('comment')) {
            $data['comment'] = $req->comment;
        }

        Maintenance::create($data);

        $car = Car::findOrFail($req->car_id);

        // Supprimer toutes les notifications liées à cette voiture
        Notification::where('car_id', $car->id)->delete();

        // Réinitialiser le compteur
        $car->rest = 0;

        // Remettre le statut à disponible
        $car->status = 'disponible';

        $car->save();

        return redirect()->route('maintenance.index', $req->car_id)
            ->with('success', 'Maintenance ajoutée avec succès et notification supprimée');
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $car = $maintenance->car;

        return view('maintenances.edit', compact('maintenance', 'car'));
    }

    /**
     * Mettre à jour une maintenance
     */
    public function update(Request $req, string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $req->validate([
            'car_id' => 'required|exists:cars,id',
            'type' => 'required|string|max:255',
            'maintenance_date' => 'required|date|before_or_equal:today',
            'cost' => 'required|numeric|min:0',
            'mileage' => 'required|numeric|min:0',
        ], [
            'car_id.required' => 'La voiture est obligatoire',
            'car_id.exists' => 'Cette voiture n’existe pas',
            'type.required' => 'Le type de maintenance est obligatoire',
            'maintenance_date.required' => 'La date est obligatoire',
            'maintenance_date.date' => 'Format de date invalide',
            'maintenance_date.before_or_equal' => 'La date ne peut pas être dans le futur',
            'cost.required' => 'Le coût est obligatoire',
            'cost.numeric' => 'Le coût doit être un nombre',
            'mileage.required' => 'Le kilométrage est obligatoire',
            'mileage.numeric' => 'Le kilométrage doit être un nombre',
        ]);

        $maintenance->update($validated);

        // Désactiver l’indicateur de maintenance
        $car = Car::findOrFail($req->car_id);
        $car->maintenance_needed = false;
        $car->save();

        return redirect()->route('maintenance.index', $req->car_id)
            ->with('success', 'Modification effectuée avec succès');
    }

    /**
     * Supprimer une maintenance
     */
    public function destroy(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $car_id = $maintenance->car_id;
        $maintenance->delete();

        return redirect()
            ->route('maintenance.index', $car_id)
            ->with('success', 'Maintenance supprimée avec succès');
    }

    /**
     * Liste des voitures nécessitant une maintenance
     */
    public function carsNeedingMaintenance()
    {
        $cars = Car::whereHas('notifications')->get();

        return view('maintenances.cars_needing', compact('cars'));
    }
}