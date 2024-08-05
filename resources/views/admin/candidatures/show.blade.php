<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations du Candidat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card-custom {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header-custom {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-body-custom {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .card-body-custom p {
            margin-bottom: 10px;
        }

        .upload-btn {
            margin-top: 10px;
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .upload-btns {
            margin-top: 10px;
            display: inline-block;
            padding: 10px 15px;
            background-color: #fbff00e5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .upload-btn:hover {
            background-color: #0056b3;
        }

        .btn-uniform {
            height: 50px;
        }
    </style>
</head>

<body>

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                Informations du Candidat <b>{{ $candidature->name }} {{ $candidature->firstname }}</b>
            </div>
            <div class="card-body card-body-custom">
                <p><b>Nom:</b> {{ $candidature->name }}</p>
                <p><b>Prénom:</b> {{ $candidature->firstname }}</p>
                <p><b>Adresse:</b> {{ $candidature->adresse }}</p>
                <p><b>Sexe:</b> {{ $candidature->sexe ==='M' ? 'Masculin' : 'Féminin' }}</p>
                <p><b>Profil:</b> {{ $candidature->category->name }}</p>
                <p><b>CV:</b> <a href="{{ route('candidatures.showPdf', $candidature->id) }}" target="_blank"
                        class="upload-btn">Télécharger CV</a></p>
                <p><b>Motivation:</b> {{ $candidature->motivation }}</p>

                <p class="d-flex mt-3">
                    <a href="{{ route('candidatures.index') }}" class="btn btn-secondary me-2 flex-fill">Retour</a>

                    @if ($candidature->statut == 'en attente')
                        <a href="#" class="btn btn-primary flex-fill" title="Programme entretien"
                            data-bs-toggle="modal" data-bs-target="#entretienmodal">
                            <i class="fas fa-clipboard-list"></i> Programme entretien
                        </a>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="entretienmodal" tabindex="-1" aria-labelledby="entretienmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="entretienmodalLabel">Programme entretien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire ou contenu de la modal -->
                    <form action="{{ route('entretiens.store', $candidature->id) }}" method="POST">
                        @csrf
                        <!-- Ajoutez les champs de votre formulaire ici -->
                        <div class="mb-3">
                            <label for="interview_date_time" class="form-label">Date et Heure de l'entretien</label>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
