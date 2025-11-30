<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="{{ $theme ?? 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Trabalho Final</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="bg-body-tertiary d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container text-center" style="max-width: 600px;">
            <h1 class="display-4 mb-4">Sistema Slasher Streetwear</h1>

            <div class="card p-4 shadow-lg">
                <h2 class="card-title mb-3">Bem-vindo!</h2>
                <p class="card-text">Para acessar o sistema de Produtos e Categorias da loja Slasher Streetwear, que utiliza CRUD, Sessão, Cookie e Upload de Arquivos, por favor, inicie a sessão.</p>

                @if(session('user_name'))
                    <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg mt-3">Acessar Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3">Fazer Login</a>
                @endif
            </div>

            <div class="mt-4">
                @include('partials.theme-toggle', ['theme' => $theme])
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>