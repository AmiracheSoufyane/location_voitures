<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|unique:clients',
            'national_id' => 'required|unique:clients|max:10',
            'city' => 'required',
            'country' => 'required',
            'address' => 'required',
            'license_image_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'license_image_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'national_id_image_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'national_id_image_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Logique pour uploader les 4 images
        $images = [
            'license_image_front', 'license_image_back', 
            'national_id_image_front', 'national_id_image_back'
        ];

        foreach ($images as $img) {
            if ($request->hasFile($img)) {
                $file = $request->file($img);
                $filename = time() . '_' . $img . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/clients'), $filename);
                $data[$img] = 'uploads/clients/' . $filename;
            }
        }

        Client::create($data);

        return redirect()->route('clients.index')->with('success', 'Client enregistré avec succès !');
    }
    public function show(string $id)
{
    // On récupère le client ou on renvoie une erreur 404 si l'ID est faux
    $client = Client::findOrFail($id);
    
    // On charge aussi ses réservations pour voir son historique
    $client->load('reservations.car');

    return view('clients.show', compact('client'));
}

    // Affiche le formulaire de modification
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // Enregistre les modifications
    public function update(Request $request, Client $client)
{
    // 1. Validation : 'unique' doit ignorer l'ID actuel du client pour ne pas bloquer
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'license_number' => 'required|unique:clients,license_number,' . $client->id,
        'national_id' => 'required|unique:clients,national_id,' . $client->id,
        'city' => 'required',
        'address' => 'required',
        // Les images sont 'nullable' car on ne veut pas forcer l'upload à chaque modification
        'license_image_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'license_image_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'national_id_image_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'national_id_image_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Gestion des fichiers (Seulement si un nouveau fichier est envoyé)
    $fields = ['license_image_front', 'license_image_back', 'national_id_image_front', 'national_id_image_back'];
    
    foreach ($fields as $field) {
        if ($request->hasFile($field)) {
            // Optionnel : Supprimer l'ancienne image physiquement ici pour gagner de la place
            $filename = time() . '_' . $field . '.' . $request->$field->extension();
            $request->$field->move(public_path('uploads/clients'), $filename);
            $validated[$field] = $filename;
        } else {
            // Si pas de nouveau fichier, on retire le champ pour ne pas écraser par du vide
            unset($validated[$field]);
        }
    }

    $client->update($validated);

    return redirect()->route('clients.index')->with('success', 'Informations du client mises à jour !');
}

    public function destroy(Client $client)
{
        // Sécurité : on vérifie si le client a des réservations en cours
        if ($client->reservations()->count() > 0) {
            return redirect()->route('clients.index')
                            ->with('error', 'Impossible de supprimer ce client car il possède des réservations actives.');
        }

        // Suppression des images (facultatif mais propre)
        // Tu peux ajouter ici la logique pour supprimer les fichiers dans public/uploads/clients/

        $client->delete();

        return redirect()->route('clients.index')
                        ->with('success', 'Le client a été supprimé avec succès.');
}
}