<?php

namespace App\Http\Controllers;

use App\Http\Requests\createCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categorie.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categorie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        // Création du code à partir des premières lettres du nom
        $code = strtoupper(substr($request->nom, 0, 3));

        // Création de la catégorie
        $category = Category::create([
            'name' => $request->nom,
            'code' => $code,
            'user_id' => auth()->user()->id, // Assigne l'ID de l'utilisateur actuellement connecté
        ]);

        return redirect()->route('categorie.index')->with('success', 'La catégorie a été insérée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = Category::findOrFail($id);
        return view('admin.categorie.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $categorie)
    {

        $request->validate([
            'nom' => 'required|string|max:255',
        ]);
        // Création du code à partir des premières lettres du nom
        $code = strtoupper(substr($request->nom, 0, 3));
        $nom = ucfirst($request->input('nom'));

        // Création de la catégorie
        $categorie->update([
            'name' => $nom,
            'code' => $code,
            'user_id' => auth()->user()->id, // Assigne l'ID de l'utilisateur actuellement connecté
        ]);
        // Définir un message de succès et rediriger
        session()->flash('success', 'La catégorie a été modifiée avec succès.');
        return redirect()->route('categorie.index');
    }

    public function desactivate($id)
    {
        $category = Category::find($id);
        if ($category) {
            // Inverser la valeur de is_active
            $category->is_active = !$category->is_active;
            $category->save();
        }
        return redirect()->route('categorie.index')->with('success', 'Statut de la catégorie mis à jour avec succès.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorie = Category::findOrFail($id);

        $categorie->delete();

        return redirect()->back()->with('success', 'La catégorie a été supprimé avec succès.');
    }
}
