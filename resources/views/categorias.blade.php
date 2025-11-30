<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="{{ $theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-body-tertiary">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Categorias</h1>
            <div class="d-flex gap-2 align-items-center">
                @include('partials.theme-toggle', ['theme' => $theme])
                <a href="/dashboard" class="btn btn-info btn-sm">Voltar ao Dashboard</a>
            </div>
        </div>

        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h3>Cadastrar Nova Categoria</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('/categorias') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Categoria:</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                             <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Categoria</button>
                </form>
            </div>
        </div>

        <hr>

        <h2>Categorias Cadastradas</h2>

        @if($categorias->isEmpty())
            <p class="text-muted">Nenhuma categoria cadastrada ainda.</p>
        @else
            <ul class="list-group">
                @foreach($categorias as $categoria)
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <strong class="fs-5">{{ $categoria->nome }}</strong>

                        <div class="d-flex gap-2">
                            <a href="{{ url('/categorias/' . $categoria->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ url('/categorias/' . $categoria->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar a categoria {{ $categoria->nome }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Apagar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>