{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le Statut</title>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/pages/all.min.css') }}">
</head>

<body>

    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Changer le Statut de l'Entretien</h2>

        <form action="{{ route('entretiens.updateStatut', $entretien->candidatures->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select" required>
                    <input type="hidden" name="_method" value="PATCH">
                    <option value="en attente" {{ $entretien->candidatures->statut == 'en attente' ? 'selected' : '' }}>
                        en attente
                    </option>
                    <option value="en cours"{{ $entretien->candidatures->statut == 'en cous' ? 'selected' : '' }}> en
                        cours
                    </option>
                    <option value="accepté"{{ $entretien->candidatures->statut == 'accepté' ? 'selected' : '' }}> en
                        cours
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Changer le Statut</button>
        </form>
    </div>
</body>

</html> --}}
