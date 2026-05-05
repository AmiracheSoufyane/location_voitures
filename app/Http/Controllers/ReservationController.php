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
        //
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

        public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}