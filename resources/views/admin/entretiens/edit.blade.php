{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($entretien) ? 'Modifier l\'Entretien' : 'Planifier un Entretien' }}</title>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/pages/all.min.css') }}">
</head>

<body>

    <div class="container mt-5">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <h2>{{ isset($entretien) ? 'Modifier l\'Entretien' : 'Planifier un Entretien' }}</h2>

        <form action="{{ isset($entretien) ? route('entretiens.update', $entretien->id) : route('entretiens.store') }}" method="POST">
            @csrf
            @if(isset($entretien))
            @method('PUT')
            @endif
            <div class="mb-3">
                <label for="candidat_id" class="form-label">Candidat</label>
                <select name="candidat_id" id="candidat_id" class="form-select" required>
                    <option value="" disabled selected>Sélectionner un candidat</option>
                    @foreach($candidats as $candidat)
                    <option value="{{ $candidat->id }}" {{ isset($entretien) && $entretien->candidat_id == $candidat->id ? 'selected' : '' }}>
                        {{ $candidat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="intervieweur_id" class="form-label">Intervieweur</label>
                <select name="intervieweur_id" id="intervieweur_id" class="form-select" required>
                    <option value="" disabled selected>Sélectionner un intervieweur</option>
                    @foreach($intervieweurs as $intervieweur)
                    <option value="{{ $intervieweur->id }}" {{ isset($entretien) && $entretien->intervieweur_id == $intervieweur->id ? 'selected' : '' }}>
                        {{ $intervieweur->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="interview_date_time" class="form-label">Date & Heure</label>
                <input type="datetime-local" name="interview_date_time" id="interview_date_time" class="form-control" value="{{ isset($entretien) ? $entretien->interview_date_time : old('date_heure') }}" required>
            </div>

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select" required>
                    <option value="en cours" {{ isset($entretien) && $entretien->statut == 'en cours' ? 'selected' : '' }}>Programmé</option>
                    <option value="accepté" {{ isset($entretien) && $entretien->statut == 'accepté' ? 'selected' : '' }}>Terminé</option>
                    <option value="en attente" {{ isset($entretien) && $entretien->statut == 'en attente' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($entretien) ? 'Mettre à Jour' : 'Planifier' }}</button>
        </form>
    </div>

    <script src="{{ url('/js/pages/bootstrap.bundle.min.js') }}"></script>
</body>

</html> --}}
