<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCandidatureRequest;
use App\Models\Candidature;
use App\Models\Category;
use Dotenv\Store\File\Paths;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer toutes les catégories pour les options de filtre
        $categories = Category::all();

        // Initialiser la requête pour les candidatures avec la relation 'category'
        $candidatures = Candidature::with('category')
            ->when($request->statut != '', function ($q) use ($request) {
                return $q->where('statut', $request->statut);
            })
            ->when($request->category_id != '', function ($q) use ($request) {
                return $q->where('category_id', $request->category_id);
            })
            ->paginate(10);

        return view('admin.candidatures.index', compact('candidatures', 'categories'));
    }

    public function showPdf($id)
    {

        // Récupérer la candidature par ID
        $candidature = Candidature::findOrFail($id);

        // Chemin du fichier PDF lié à la candidature
        $filePath = 'fichierPdf/' . $candidature->file;

        // Vérifier si le fichier PDF existe
        if (!file_exists($filePath)) {
            abort(404, 'Le fichier PDF n\'existe pas.');
        }
        // return response()->download($filePath, 'download'); pour télécharger les fichiers pdf dans un dossier
        return response()->file($filePath);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidature = Candidature::findOrFail($id);
        return view('admin.candidatures.show', compact('candidature'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidature $candidature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidature $candidature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidatures = Candidature::findOrFail($id);

        if ($candidatures->statut == 'en attente' || $candidatures->statut == 'terminé') {

            $candidatures->delete();

            return redirect()->back()->with('success', 'La candidature a été supprimée avec succès.');
        } else {
            return redirect()->back()->with('error', 'La candidature ne peut être supprimée car elle est en cours.');
        }
    }


}
