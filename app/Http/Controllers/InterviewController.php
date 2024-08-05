<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Category;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Http\Request;

class InterviewController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $entretiens = Interview::with('candidatures')->get();
        $statut = $request->input('statut'); // Obtention du statut depuis la requête

        $entretiens = Interview::with('candidatures') // Charger la relation candidatures
            ->when($statut, function ($query, $statut) {
                return $query->whereHas('candidatures', function ($query) use ($statut) {
                    $query->where('statut', $statut);
                });
            })
            ->paginate(10);

        return view('admin.entretiens.index', compact('entretiens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $candidatures = Candidature::where('statut', 'en attente')->get();
        // $intervieweurs = User::where('id', 'name')->get();
        // $intervieweurs = User::all();
        return view('admin.entretiens.create', compact('candidatures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'interview_date_time' => 'required|date',
            'cand_id' => 'required|exists:candidatures,id',
        ]);

        $entretiens = Interview::create([
            'interview_date_time' => $request->input('interview_date_time'),
            'cand_id' => $request->input('cand_id'),
            'user_id' => auth()->user()->id,
        ]);

        // Récupérer le candidat associé à l'entretien
        $candidat = Candidature::findOrFail($request->cand_id);

        // Mettre à jour le statut du candidat
        $candidat->statut = 'programmé';
        $candidat->save();

        session()->flash('success', 'Entretien planifié avec succès.');
        return redirect()->route('entretiens.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    // Affiche le formulaire pour éditer un entretien
    public function edit($id)
    {
        $entretien = Interview::with('candidature')->findOrFail($id);
        $candidats = Candidature::all();
        // $intervieweurs = User::where('is_admin', 'intervieweur')->get();
        return view('admin.entretiens.edit', compact('entretien', 'candidats'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation des données de la requête
        $request->validate([
            'interview_date_time' => 'required|date',
            'cand_id' => 'required|exists:candidatures,id',
        ]);

        // Trouver l'entretien par ID
        $entretien = Interview::findOrFail($id);

        // Mettre à jour les détails de l'entretien
        $entretien->interview_date_time = $request->input('interview_date_time');
        $entretien->cand_id = $request->input('cand_id');
        $entretien->user_id = auth()->user()->id;
        $entretien->save();

        // Récupérer le candidat associé à l'entretien
        $candidat = Candidature::findOrFail($request->cand_id);

        // Mettre à jour le statut du candidat
        $candidat->statut = 'programmé';
        $candidat->save();

        // Envoyer des notifications par email ou SMS ici (si nécessaire)

        // Ajouter un message flash de succès
        session()->flash('success', 'Entretien mis à jour avec succès.');

        // Rediriger vers la liste des entretiens
        return redirect()->route('entretiens.index');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Trouver l'entretien par ID
        $entretien = Interview::findOrFail($id);

        // Vérifier si le statut du candidat est "terminé"
        if ($entretien->candidatures && $entretien->candidatures->statut === 'terminé') {
            // Supprimer l'entretien
            $entretien->delete();

            // Envoyer des notifications par email ou SMS ici

            session()->flash('success', 'Entretien supprimé avec succès.');
        }

        return redirect()->route('entretiens.index');
    }



    public function updateStatut(Request $request, $id)
    {
        // // Trouver l'entretien par ID
        // $entretien = Interview::find($id);

        // // Validation de la demande
        // $validatedData = $request->validate([
        //     'statut' => 'required|in:terminé',
        // ]);

        // // Accéder à la candidature associée à cet entretien
        // $candidatures = $entretien->candidatures;

        // if ($candidatures) {
        //     // Mettre à jour le statut de la candidature
        //     $candidatures->statut = $validatedData['statut'];
        //     $candidatures->save();

        //     // Flash message pour succès
        //     session()->flash('success', 'Statut de l\'entretien mis à jour avec succès.');

        //     return redirect()->route('entretiens.index');
        // }

        // Validation des données
        $validatedData = $request->validate([
            'statut' => 'required|string'
        ]);

        // Trouver l'entretien avec ses candidatures
        $entretien = Interview::with('candidatures')->findOrFail($id);

        // Récupérer la première candidature avec le statut 'en attente'
        $candidatures = $entretien->candidatures->firstWhere('statut', 'programmé');
        if ($candidatures && $candidatures->statut === 'programmé') {
            // Mettre à jour le statut de la candidature
            $candidatures->statut = $validatedData['statut'];

            $candidatures->save();

            // Flash message pour succès
            session()->flash('success', 'Statut de l\'entretien mis à jour avec succès.');

            return redirect()->route('entretiens.index');
        } else {
            // Flash message pour erreur si la candidature n'existe pas ou si le statut n'est pas 'en attente'
            session()->flash('error', 'Candidature introuvable ou statut déjà mis à jour.');

            return redirect()->route('entretiens.index');
        }
    }
}
