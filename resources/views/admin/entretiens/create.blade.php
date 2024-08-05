<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($entretien) ? 'Modifier l\'Entretien' : 'Planifier un Entretien' }}</title>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/pages/all.min.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

        <form action="" method="POST">
            @csrf

            <div class="mb-3">
                <label for="cand_id" class="form-label">Candidat</label>
                <label for="cand_id" class="form-label">Candidats</label>
                @foreach ($candidatures as $candidature)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cand_id" id="cand_{{ $candidature->id }}"
                            value="{{ $candidature->id }}" {{ old('cand_id') == $candidature->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="cand_{{ $candidature->id }}">
                            {{ $candidature->name }} {{ $candidature->firstname }}
                        </label>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="planifiermodal" tabindex="-1" aria-labelledby="planifiermodalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="planifiernmodalLabel">Programme entretien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulaire ou contenu de la modal -->
                                    <form action="{{ route('entretiens.store', $candidature->id) }}" method="POST">
                                        @csrf
                                        <!-- Ajoutez les champs de votre formulaire ici -->
                                        <div class="mb-3">
                                            <label for="interview_date_time" class="form-label">Date et Heure de
                                                l'entretien</label>
                                            <input type="datetime-local" class="form-control" id="interview_date_time"
                                                name="interview_date_time" required>
                                        </div>
                                        <input type="hidden" name="cand_id" value="{{ $candidature->id }}">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>

    <a href="{{ route('entretiens.index') }}" class="btn btn-secondary me-2 flex-fill">Retour</a>

    @if (isset($candidature) && $candidature->statut == 'en attente')
        <a href="#" class="btn btn-primary flex-fill" title="Programme entretien" data-bs-toggle="modal"
            data-bs-target="#planifiermodal">
            <i class="fas fa-clipboard-list"></i> Programme entretien
        </a>
    @endif
    </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ url('/js/pages/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
