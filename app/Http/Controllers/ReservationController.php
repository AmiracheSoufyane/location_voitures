<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Car;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Liste des réservations avec optimisation des requêtes.
     */
    public function index()
    {
        $reservations = Reservation::with(['client', 'car', 'user'])->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * API : Recherche dynamique des clients (Nom ou CIN).
     */
    public function searchClients(Request $request)
    {
        $search = $request->get('q');
        return Client::where('name', 'LIKE', "%$search%")
            ->orWhere('national_id', 'LIKE', "%$search%")
            ->limit(10)
            ->get(['id', 'name', 'national_id']);
    }

    /**
     * API : Recherche dynamique des voitures disponibles.
     */
   public function searchCars(Request $request)
{
    $query = $request->get('q');
    
    // On cherche par marque ou modèle
    $cars = Car::where('brand', 'LIKE', "%{$query}%")
                ->orWhere('model', 'LIKE', "%{$query}%")
                ->orWhere('registration', 'LIKE', "%{$query}%")
                ->where('status', 'disponible') // Optionnel : seulement les dispo
                ->get(['id', 'brand', 'model', 'registration', 'daily_price']);

    return response()->json($cars);
}
    public function create()
{
    // On ne récupère plus tous les clients ici pour éviter l'erreur
    $cars = Car::all(); 
    return view('reservations.create', compact('cars'));
}

    public function store(Request $request)
{
        dd($request->all());

    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'car_id'    => 'required|exists:cars,id',
        'date_start' => 'required|date|after_or_equal:today',
        'date_end'   => 'required|date|after:date_start',
        'price'      => 'required|numeric|min:0',
    ]);

    $validated['user_id'] = Auth::id();

    // Vérification de collision des dates
    $exists = Reservation::where('car_id', $request->car_id)
        ->where(function ($query) use ($request) {
            $query->where(function($q) use ($request) {
                $q->whereBetween('date_start', [$request->date_start, $request->date_end])
                  ->orWhereBetween('date_end', [$request->date_start, $request->date_end]);
            })
            ->orWhere(function($q) use ($request) {
                $q->where('date_start', '<=', $request->date_start)
                  ->where('date_end', '>=', $request->date_end);
            });
        })->exists();

    if ($exists) {
        return back()
            ->withErrors(['car_id' => 'Ce véhicule est déjà réservé pour ces dates.'])
            ->withInput(); // Très important pour garder les noms écrits
    }

    $reservation = Reservation::create($validated);

    // On met à jour le statut du véhicule
    Car::where('id', $request->car_id)->update(['status' => 'loué']);

    return redirect()->route('reservations.index')->with('success', 'Contrat créé avec succès !');
}
    public function edit(Reservation $reservation)
    {
        // On charge les relations actuelles pour les afficher par défaut dans le formulaire
        $reservation->load(['client', 'car']);
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'car_id'    => 'required|exists:cars,id',
            'date_start' => 'required|date',
            'date_end'   => 'required|date|after:date_start',
            'price'      => 'required|numeric|min:0',
        ]);

        // LOGIQUE SI LA VOITURE CHANGE
        if ($reservation->car_id !== $request->car_id) {
            // 1. Libérer l'ancienne voiture
            Car::where('id', $reservation->car_id)->update(['status' => 'disponible']);
            // 2. Bloquer la nouvelle voiture
            Car::where('id', $request->car_id)->update(['status' => 'loué']);
        }

        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'La réservation a été modifiée.');
    }

    public function show($id)
{
    // On récupère la réservation avec ses relations
    $reservation = Reservation::with(['client', 'car'])->findOrFail($id);

    return view('reservations.show', compact('reservation'));
}

    public function destroy(Reservation $reservation)
    {
        if ($reservation->car) {
            $reservation->car->update(['status' => 'disponible']);
        }

        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Réservation supprimée.');
    }
}