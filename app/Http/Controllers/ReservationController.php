<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Les imports indispensables que j'avais oubliés :
use App\Models\Reservation;
use App\Models\Car;
use App\Models\Client;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // On récupère les réservations avec les infos du client et de la voiture
    // pour éviter le problème du "N+1 query"N
    $reservations = Reservation::with(['client', 'car', 'user'])->latest()->get();
    return view('reservations.index', compact('reservations'));
}

    public function create()
    {
        // On ne récupère que les voitures 'disponible'
        $cars = Car::where('status', 'disponible')->get();
        $clients = Client::all();

        return view('reservations.create', compact('cars', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'car_id'      => 'required|exists:cars,id',
            'date_start'  => 'required|date|after_or_equal:today',
            'date_end'    => 'required|date|after:date_start',
            'price'       => 'required|numeric',
        ]);

        // Utilisation de Auth pour l'ID de l'employé connecté
        $validated['user_id'] = Auth::id();

        // Création de la réservation
        $reservation = Reservation::create($validated);

        // Mise à jour du statut de la voiture
        $car = Car::find($request->car_id);
        $car->update(['status' => 'loué']);

        return redirect()->route('reservations.index')->with('success', 'Contrat créé !');
    }



// Affiche le formulaire d'édition
    public function edit(Reservation $reservation)
    {
        // On a besoin de renvoyer la liste des clients et voitures pour les menus déroulants
        $clients = Client::all();
        $cars = Car::all();
        
        return view('reservations.edit', compact('reservation', 'clients', 'cars'));
    }

// Enregistre les modifications
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'car_id' => 'required|exists:cars,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'price' => 'required|numeric|min:0',
        ]);

        // On met à jour les données
        $reservation->update($request->all());

        return redirect()->route('reservations.index')
                        ->with('success', 'La réservation a été modifiée avec succès.');
    }

    public function show(Reservation $reservation)
{
    // On charge les relations pour afficher le nom du client, la marque de la voiture, etc.
    $reservation->load(['client', 'car', 'user']);

    return view('reservations.show', compact('reservation'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}