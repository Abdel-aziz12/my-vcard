<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Entretiens</title>
    {{-- <link href="{{ url('/css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/pages/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h2>Liste des Entretiens</h2>
            <a href="{{ route('entretiens.create') }}" class="btn btn-primary">Planifier un Entretien</a>
        </div>

        <form action="" method="get">
            <div class="row align-items-center pb-3">
                <div class="col-md-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="">Sélectionner un statut</option>
                        <option value="programmé" {{ request('statut') == 'programmé' ? 'selected' : '' }}>Programmé
                        </option>
                        <option value="terminé" {{ request('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary mt-4">Filtrer</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Candidat</th>
                    <th>Date & Heure</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if (isset($entretiens)) --}}

                @if (count($entretiens) > 0)
                    @foreach ($entretiens as $entretien)
                        <tr>
                            <td>
                                @if ($entretien->candidatures)
                                    {{ $entretien->id }}
                                @endif
                            </td>
                            <td>
                                @if ($entretien->candidatures)
                                    {{ $entretien->candidatures->name }} {{ $entretien->candidatures->firstname }}
                                @endif
                            </td>
                            <td>
                                @if ($entretien->candidatures)
                                    {{ $entretien->interview_date_time }}
                                @endif
                            </td>
                            <td>
                                @if ($entretien->candidatures)
                                    <span
                                        class="badge bg-{{ $entretien->candidatures->statut == 'terminé' ? 'success' : ($entretien->candidatures->statut == 'en attente' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($entretien->candidatures->statut) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($entretien->candidatures)
                                    @if ($entretien->candidatures->statut === 'programmé')
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modifiermodal">Modifier</a>
                                    @endif
                                    @if ($entretien->candidatures->statut === 'terminé')
                                        <form action="{{ route('entretiens.destroy', $entretien->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Voulez-vous vraiment supprimer cet entretien ?')">Supprimer</button>
                                        </form>
                                    @endif
                                    @if ($entretien->candidatures->statut === 'programmé')
                                        <a href="#" class="btn btn-info btn-sm" title="Changer Statut"
                                            data-bs-toggle="modal" data-bs-target="#statutmodal">Changer Statut</a>
                                    @endif
                                @endif
                            </td>

                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="statutmodal" tabindex="-1" aria-labelledby="statutmodalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="statutmodalLabel">Changer le Statut de l'Entretien
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('entretiens.updateStatut', [$entretien->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="mb-3">
                                                <label for="statut" class="form-label">Statut</label>
                                                <select name="statut" id="statut" class="form-select" required>
                                                    @if ($entretien->candidatures)
                                                        <option
                                                            value="terminé"{{ $entretien->candidatures->statut == 'terminé' ? 'selected' : '' }}>
                                                            terminé</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Changer le Statut</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modifiermodal" tabindex="-1" aria-labelledby="modifiermodalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modifiermodalLabel">Changer l'heure de l'Entretien
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('entretiens.update', $entretien->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="interview_date_time" class="form-label">Date et Heure de
                                                    l'entretien</label>
                                                <input type="datetime-local" class="form-control"
                                                    id="interview_date_time" name="interview_date_time"
                                                    value="{{ old('interview_date_time', $entretien->interview_date_time) }}"
                                                    required>
                                            </div>
                                            <input type="hidden" name="cand_id"
                                                value="{{ old('cand_id', $entretien->cand_id) }}">

                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- @else
                    <h3>Pas de données disponibles</h3>
                @endif --}}
                    {{ $entretiens->links() }} <!-- Pour la pagination -->
                @else
                    <tr>
                        <td colspan="5">
                            {{-- <div class="alert alert-warning" role="alert"> --}}
                            <h3 class="alert alert-warning"> Pas de données disponibles.</h3>
                            {{-- </div> --}}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ url('/js/pages/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
