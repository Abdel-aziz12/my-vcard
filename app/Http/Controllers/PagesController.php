<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Candidature;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class PagesController extends Controller
{
    public function home()
    {
        // Récupérer uniquement les catégories actives
        $categories = Category::where('is_active', true)->get();
        return view('pages.home', compact('categories'));
    }


    public function template()
    {
        return view('pages.template');
    }

    // public function store(Request $request)
    // {
    //     // Validation des données
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'firstname' => 'required|string|max:255',
    //         'sexe' => 'required',
    //         'adresse' => 'required|string',
    //         'phone' => [
    //             'required',
    //             'string',
    //             'max:20',
    //             function ($attribute, $value, $fail) {
    //                 $phoneUtil = PhoneNumberUtil::getInstance();
    //                 try {
    //                     $numberProto = $phoneUtil->parse($value, null);
    //                     if (!$phoneUtil->isValidNumber($numberProto)) {
    //                         $fail('Le numéro de téléphone est invalide.');
    //                     }
    //                 } catch (NumberParseException $e) {
    //                     $fail('Le numéro de téléphone est incorrect.');
    //                 }
    //             }
    //         ],
    //         'email' => 'required|email|max:255',
    //         'file' => 'required|mimes:pdf|max:40960',
    //         'motivation' => 'required|string',
    //         'category_id' => 'required|exists:categories,id',
    //     ]);

    //     // Formatage du prénom et du nom pour mettre en majuscule la première lettre
    //     $validatedData['name'] = ucfirst(strtolower($validatedData['name']));
    //     $validatedData['firstname'] = ucfirst(strtolower($validatedData['firstname']));


    //     // Formatage du numéro de téléphone au format E.164
    //     $phoneUtil = PhoneNumberUtil::getInstance();
    //     try {
    //         $numberProto = $phoneUtil->parse($request->input('phone'), null);
    //         $formattedNumber = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
    //         $validatedData['phone'] = $formattedNumber;
    //     } catch (NumberParseException $e) {
    //         return back()->withErrors(['phone' => 'Le numéro de téléphone est incorrect.']);
    //     }

    //     // Stocker le fichier téléchargé
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $destinationPath = 'fichierPdf/';
    //         $filepdf = date('YmdHis') . "." . $file->getClientOriginalExtension();
    //         $file->move($destinationPath, $filepdf);
    //         $validatedData['file'] = $filepdf;
    //     }

    //     // Vérifier si la candidature existe déjà
    //     $existeCandidats = Candidature::where('name', $validatedData['name'])
    //         ->where('firstname', $validatedData['firstname'])
    //         ->where('category_id', $validatedData['category_id'])
    //         ->exists();

    //     if ($existeCandidats) {
    //         session()->flash('error', 'Votre candidature existe déjà pour ce profil.');
    //         return redirect()->back();
    //     }

    //     // Insérer les données dans la base de données
    //     Candidature::create($validatedData);

    //     session()->flash('success', 'Votre candidature a été bien prise en compte');
    //     return redirect()->back();
    // }


    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'sexe' => 'required',
            'adresse' => 'required|string',
            'phone' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    $phoneUtil = PhoneNumberUtil::getInstance();
                    try {
                        $numberProto = $phoneUtil->parse($value, null);
                        if (!$phoneUtil->isValidNumber($numberProto)) {
                            $fail('Le numéro de téléphone est invalide.');
                        }
                    } catch (NumberParseException $e) {
                        $fail('Le numéro de téléphone est incorrect.');
                    }
                }
            ],
            'email' => 'required|email|max:255',
            'file' => 'required|mimes:pdf|max:40960',
            'motivation' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Formatage du prénom et du nom pour mettre en majuscule la première lettre
        $validatedData['name'] = ucfirst(strtolower($validatedData['name']));
        $validatedData['firstname'] = ucfirst(strtolower($validatedData['firstname']));

        // Formatage du numéro de téléphone au format E.164
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneUtil->parse($request->input('phone'), null);
            $formattedNumber = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
            $validatedData['phone'] = $formattedNumber;
        } catch (NumberParseException $e) {
            return back()->withErrors(['phone' => 'Le numéro de téléphone est incorrect.']);
        }

        // Stocker le fichier téléchargé
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = 'fichierPdf/';
            $filepdf = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filepdf);
            $validatedData['file'] = $filepdf;
        }

        // Vérifier si la candidature existe déjà
        $candidature = Candidature::where('name', $validatedData['name'])
            ->where('firstname', $validatedData['firstname'])
            ->where('category_id', $validatedData['category_id'])
            ->first();

        if ($candidature) {
            // Si la candidature existe, mettre à jour son CV, sa motivation, et son statut
            if (isset($validatedData['file'])) {
                $candidature->file = $validatedData['file'];
            }
            $candidature->motivation = $validatedData['motivation'];
            $candidature->statut = 'en attente'; // Définir le statut par défaut en attente
            $candidature->save();

            session()->flash('success', 'Votre candidature a été mise à jour avec succès.');
        } else {
            // Si la candidature n'existe pas, définir le statut par défaut et créer une nouvelle candidature
            $validatedData['statut'] = 'en attente';
            Candidature::create($validatedData);

            session()->flash('success', 'Votre candidature a été bien prise en compte.');
        }

        return redirect()->back();
    }
}
