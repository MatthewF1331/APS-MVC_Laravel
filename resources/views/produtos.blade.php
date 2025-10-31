<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light"> <div class="container mt-5"> <h1 class="mb-4">Gestão de Produtos</h1>

        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h3>Cadastrar Novo Produto</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('/produtos') }}" method="POST">
                    @csrf <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Produto:</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}">
                        @error('nome')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição (Opcional):</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço (Opcional):</label>
                        <input type="text" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco" placeholder="Ex: 99.90" value="{{ old('preco') }}">
                        @error('preco')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Salvar Produto</button>
                </form>
            </div>
        </div>

        <h2>Produtos Cadastrados</h2>
        
        @if($produtos->isEmpty())
            <p class="text-muted">Nenhum produto cadastrado ainda.</p>
        @else
            <ul class="list-group">
                @foreach($produtos as $produto)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        
                        <div>
                            <strong class="fs-5">{{ $produto->nome }}</strong>
                            
                            @if($produto->preco)
                                <span class="badge bg-success ms-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                            @endif
                            
                            @if($produto->descricao)
                                <small class="d-block text-muted">{{ $produto->descricao }}</small>
                            @endif
                        </div>
                        
                        <form action="{{ url('/produtos/' . $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este produto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Apagar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>