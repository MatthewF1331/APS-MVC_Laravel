<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="{{ $theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-body-tertiary">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Produtos</h1>
            <div class="d-flex gap-2">
                @include('partials.theme-toggle', ['theme' => $theme])
                <a href="/dashboard" class="btn btn-info">Voltar ao Dashboard</a>
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
                <h3>Cadastrar Novo Produto</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('/produtos') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome do Produto:</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="preco" class="form-label">Preço (Opcional):</label>
                            <input type="text" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco" placeholder="Ex: 99.90" value="{{ old('preco') }}">
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição (Opcional):</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="2">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="categorias_ids" class="form-label">Categorias:</label>
                        <select multiple class="form-select @error('categorias_ids') is-invalid @enderror" id="categorias_ids" name="categorias_ids[]">
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ in_array($categoria->id, old('categorias_ids', [])) ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                         <small class="form-text text-muted">Use Ctrl para selecionar mais de uma categoria</small>
                        @error('categorias_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem do Produto (PNG ou JPG):</label>
                        <input class="form-control @error('imagem') is-invalid @enderror" type="file" id="imagem" name="imagem" accept=".png,.jpg,.jpeg">
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Produto</button>
                </form>
            </div>
        </div>

        <hr>

        <h2>Produtos Cadastrados</h2>

        @if($produtos->isEmpty())
            <p class="text-muted">Nenhum produto cadastrado ainda.</p>
        @else
            <ul class="list-group">
                @foreach($produtos as $produto)
                    <li class="list-group-item d-flex justify-content-between align-items-center mb-2">

                        <div class="d-flex align-items-center">

                            @if($produto->image_path)
                                <img src="{{ asset('storage/' . $produto->image_path) }}" alt="Imagem do Produto" style="max-width: 60px; height: auto; border-radius: 5px; margin-right: 15px;">
                            @else
                                <span class="me-3 text-muted" style="width: 60px;">[Sem Imagem]</span>
                            @endif

                            <div>
                                <strong class="fs-5">{{ $produto->nome }}</strong>

                                @if($produto->preco)
                                    <span class="badge bg-success ms-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                @endif

                                @if($produto->descricao)
                                    <small class="d-block text-muted">{{ $produto->descricao }}</small>
                                @endif
                                
                                @if($produto->categorias->isNotEmpty())
                                    <div class="mt-1">
                                        @foreach($produto->categorias as $categoria)
                                            <span class="badge bg-secondary">{{ $categoria->nome }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ url('/produtos/' . $produto->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ url('/produtos/' . $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar o produto {{ $produto->nome }}?');">
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