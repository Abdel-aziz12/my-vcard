<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="{{ url('/css/app.css')}}" rel="stylesheet">
    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css')}}">

    <!-- Bootstrap CSS & JS Online
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
      -->
    <script src="{{ url('/js/bootstrap.bundle.min.js')}}"></script>
    <!-- END Bootstrap -->
    <link rel="stylesheet" href="{{ url('/css/style.css')}}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie </title>
</head>

<body>


    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="col-md-6 text-center mb-3">
            <h2>Modifié la catégorie</h2>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categorie.update', $categories->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" name="id" style="display: none;" value="{{ $categories->id}}">
                        <div class="form-group">
                            <label for="nom">Profil:</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $categories->name) }}">
                            @error('nom')
                            <div class="text-danger">{{ $message}}</div>
                            @enderror
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Mettre à jour<i class="fas fa-sync"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
