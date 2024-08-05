<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/pages/all.min.css') }}">
    <script src="{{ url('/js/pages/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('/js/pages/all.min.js') }}"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie </title>
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
            <h2>Liste des catégories</h2>
            <a href="{{ route('categorie.create') }}" class="btn btn-primary">Ajouter catégorie</a>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Nom Profil</td>
                                <td>Code Profil</td>
                                <td>Statut</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $categorie)
                                <tr>
                                    <th scope="row">{{ $categorie->id }}</th>
                                    <td>{{ $categorie->name }}</td>
                                    <td>{{ $categorie->code }}</td>
                                    <td>
                                        {{ $categorie->is_active ? 'Activé' : 'Désactivé' }}
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{ route('categorie.edit', [$categorie->id]) }}"
                                            class="btn btn-primary me-2" title="Modifier">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>

                                        <!-- Formulaire caché pour la suppression -->
                                        <form action="{{ route('categorie.destroy', [$categorie->id]) }}"
                                            method="POST" id="delete-form-{{ $categorie->id }}" class="me-2"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" class="btn btn-danger me-2" title="Supprimer"
                                            onclick="event.preventDefault(); if(confirm('Voulez-vous vraiment supprimer cette catégorie ?')) { document.getElementById('delete-form-{{ $categorie->id }}').submit(); }">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </a>

                                        <!-- Formulaire pour activer/désactiver -->
                                        <form action="{{ route('categorie.desactivate', [$categorie->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-{{ $categorie->is_active ? 'danger' : 'success' }}">
                                                {{ $categorie->is_active ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
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
