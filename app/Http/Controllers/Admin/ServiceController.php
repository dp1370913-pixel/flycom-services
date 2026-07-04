<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // 1. Lister tous les services en grille d'administration (Image 26)
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    // 2. Enregistrer un nouveau service (Image 24)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_service'    => ['required', 'string', 'max:150'],
            'description'    => ['required', 'string'],
            'prix_indicatif' => ['required', 'numeric', 'min:0'],
            'unite'          => ['required', 'string', 'max:50'],
            'categorie'      => ['required', 'string', 'max:100'],
            'image_file'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048']
        ]);

        $imagePath = 'assets/images/default.jpg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $fileName);
            $imagePath = 'assets/images/' . $fileName;
        }

        Service::create([
            'nom_service'    => $validated['nom_service'],
            'description'    => $validated['description'],
            'prix_indicatif' => $validated['prix_indicatif'],
            'unite'          => $validated['unite'],
            'categorie'      => $validated['categorie'],
            'actif'          => $request->has('actif'),
            'image'          => $imagePath
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Le service a bien été ajouté au catalogue.');
    }

    // 3. Modifier un service existant (Image 25)
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'nom_service'    => ['required', 'string', 'max:150'],
            'description'    => ['required', 'string'],
            'prix_indicatif' => ['required', 'numeric', 'min:0'],
            'unite'          => ['required', 'string', 'max:50'],
            'categorie'      => ['required', 'string', 'max:100'],
            'image_file'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048']
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $fileName);
            $service->image = 'assets/images/' . $fileName;
        }

        $service->nom_service = $validated['nom_service'];
        $service->description = $validated['description'];
        $service->prix_indicatif = $validated['prix_indicatif'];
        $service->unite = $validated['unite'];
        $service->categorie = $validated['categorie'];
        $service->actif = $request->has('actif');
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'La fiche du service a bien été mise à jour.');
    }

    // 4. Supprimer physiquement un service du catalogue (Nouveau - 100% opérationnel)
    public function delete($id)
    {
        $service = Service::findOrFail($id);

        // Contrainte d'intégrité stricte (MLD) : Empêche la suppression si le service figure sur des devis/factures émis (sécurité comptable)
        if ($service->devis()->exists()) {
            return redirect()->route('admin.services.index')->with('error', 'Impossible de supprimer ce service car il est référencé dans des devis ou factures existants. Pour le masquer du site et des nouveaux devis, passez-le simplement en "Inactif".');
        }

        // Nettoyage de la table associative lead_services s'il y a des opportunités d'affaires liées
        $service->leads()->detach();

        // Supprimer physiquement l'image s'il y en a une spécifique et qu'elle n'est pas l'image par défaut
        if ($service->image && $service->image !== 'assets/images/default.jpg' && file_exists(public_path($service->image))) {
            @unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Le service a bien été retiré du catalogue d\'entreprise.');
    }
}