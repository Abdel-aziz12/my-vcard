<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/pages/all.min.css') }}">

    <script src="{{ url('/js/admin/jquery-3.7.1.js') }}"></script>
    <script src="{{ url('/js/admin/sweetalert2.min.js') }}"></script>
    <script src="{{ url('/js/pages/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('/js/pages/all.min.js') }}"></script>

    <script src="{{ url('/DataTables/datatables.js') }}"></script>
    <script src="{{ url('/DataTables/datatables.min.js') }}"></script>

    <link href="{{ url('/DataTables/datatables.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('/node_modules/sweetalert2/dist/sweetalert2.min.css') }}">
    <!-- END Bootstrap -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>candidature </title>
</head>


<body>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>


    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="col-md-6 text-center mb-3">
            <h2>Liste des candidatures</h2>
        </div>

        <hr>
        <form action="" method="get">
            <div class="row align-items-center pb-3">
                <div class="col-md-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="">Sélectionner un statut</option>
                        <option value="en attente" {{ request('statut') == 'en attente' ? 'selected' : '' }}>En attente
                        </option>
                        <option value="programmé" {{ request('statut') == 'programmé' ? 'selected' : '' }}>Programmé
                        </option>
                        <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Catégorie</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                {{ request('category_id') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary mt-4">Filtrer</button>
                </div>
            </div>
        </form>

        <hr style="border: 1px solid black;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>Sexe</td>
                                <td>Téléphone</td>
                                <td>CV</td>
                                <td>Motivation</td>
                                <td>Profil</td>
                                <td>Statut</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidatures as $candidature)
                                <tr>
                                    <th scope="row">{{ $candidature->id }}</th>
                                    <td>{{ $candidature->name }}</td>
                                    <td>{{ $candidature->firstname }}</td>
                                    <td>{{ $candidature->sexe === 'M' ? 'Masculin' : 'Féminin' }}</td>
                                    <td>{{ $candidature->phone }}</td>
                                    <td>{{ $candidature->file }}</td>
                                    <td>{{ $candidature->motivation }}</td>
                                    <td>{{ $candidature->category->name }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $candidature->statut == 'terminé' ? 'success' : ($candidature->statut == 'en attente' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($candidature->statut) }}
                                        </span>
                                    </td>
                                    <td class="d-flex">

                                        @if ($candidature->statut == 'terminé')
                                            <!-- Formulaire caché pour la suppression -->
                                            <form action="{{ route('candidatures.destroy', [$candidature->id]) }}"
                                                method="POST" id="delete-form-{{ $candidature->id }}"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" class="btn btn-danger btn-sm me-2" title="Supprimer"
                                                onclick="event.preventDefault(); if(confirm('Voulez-vous vraiment supprimer cette catégorie ?')) { document.getElementById('delete-form-{{ $candidature->id }}').submit(); }">
                                                <i class="fas fa-trash-alt"></i> Supprimer
                                            </a>
                                        @endif

                                        <a href="{{ route('candidatures.show', $candidature->id) }}"
                                            class="btn btn-info btn-sm me-2" title="Voir">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
