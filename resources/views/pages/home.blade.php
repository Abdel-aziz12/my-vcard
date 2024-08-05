<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="{{ url('/css/app.css')}}" rel="stylesheet">
    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="{{ url('/pages/bootstrap.min.css')}}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
    <script src="{{ url('/js/bootstrap.bundle.min.js')}}"></script>
    <!-- END Bootstrap -->
    <link rel="stylesheet" href="{{ url('/css/style.css')}}">
    <script src="{{ url('/js/script.js')}}"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management </title>
</head>

<body>

    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success')}}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error')}}
        </div>
        @endif
    </div>

    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="/index/home" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group">
                            <label for="name">Nom: </label>
                            <input type="text" name="name" id="name" class="form-control">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="firstname">Préom: </label>
                            <input type="text" name="firstname" id="firstname" class="form-control">
                            @error('firstname')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="adresse">Adresse: </label>
                            <input type="text" name="adresse" id="adresse" class="form-control">
                            @error('adresse')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sexe">Sexe: </label>
                            <select name="sexe" id="sexe" class="form-control">
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="email" name="email" id="email" class="form-control">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone: </label><br>
                            <input type="tel" name="phone" id="phone" class="form-control">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file">CV (au format PDF): </label>
                            <input type="file" name="file" id="file" class="form-control">
                            @error('file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="motivation">Motivation:</label>
                            <textarea name="motivation" id="motivation" class="form-control"></textarea>
                            @error('motivation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Profil: </label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id}}">{{ $category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

    </script> -->

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
    <script>
        const input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: "cm",
            separateDialCode: true,
            onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk","cm",
                "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
                "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
                "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"
            ],
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/utils.js",
        });
    </script>

</body>

</html>
