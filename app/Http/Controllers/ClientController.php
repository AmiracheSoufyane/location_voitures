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
            'national_id' => 'required|unique:clients',
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
        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|unique:clients,national_id,' . $client->id,
            'license_number' => 'required|string',
            'city' => 'required|string',
            // On ne rend pas les images obligatoires ici pour ne pas écraser les anciennes
            'national_id_image_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Logique pour les nouvelles images (on ne remplace que si une nouvelle est uploadée)
        if ($request->hasFile('national_id_image_front')) {
            $imageName = time().'_front.'.$request->national_id_image_front->extension();
            $request->national_id_image_front->move(public_path('uploads/clients'), $imageName);
            $data['national_id_image_front'] = 'uploads/clients/'.$imageName;
        }

        $client->update($data);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès !');
    }
    }