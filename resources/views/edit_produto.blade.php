<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="{{ $theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-body-tertiary">

    <div class="container mt-5">
        <h1 class="mb-4">Editar Produto: {{ $produto->nome }}</h1>

        <div class="d-flex gap-2 mb-3">
             @include('partials.theme-toggle', ['theme' => $theme])
            <a href="/produtos" class="btn btn-secondary">Voltar para a Lista</a>
        </div>

        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h3>Formulário de Edição</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('/produtos/' . $produto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome do Produto:</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $produto->nome) }}" required>
                            @error('nome')
                                 <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="preco" class="form-label">Preço (Opcional):</label>
                            <input type="text" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco" placeholder="Ex: 99.90" value="{{ old('preco', $produto->preco) }}">
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição (Opcional):</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="2">{{ old('descricao', $produto->descricao) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="categorias_ids" class="form-label">Categorias:</label>
                        <select multiple class="form-select @error('categorias_ids') is-invalid @enderror" id="categorias_ids" name="categorias_ids[]">
                            @php
                                $produtoCategoriaIds = $produto->categorias->pluck('id')->toArray();
                                $selectedIds = old('categorias_ids', $produtoCategoriaIds);
                            @endphp

                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ in_array($categoria->id, $selectedIds) ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                         <small class="form-text text-muted">Use Ctrl para selecionar mais de uma categoria.</small>
                        @error('categorias_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="imagem" class="form-label">Nova Imagem do Produto (PNG ou JPG):</label>
                        <input class="form-control @error('imagem') is-invalid @enderror" type="file" id="imagem" name="imagem" accept=".png,.jpg,.jpeg">
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($produto->image_path)
                            <div class="mt-2">
                                <p>Imagem Atual:</p>
                                <img src="{{ asset('storage/' . $produto->image_path) }}" alt="Imagem do Produto" style="max-width: 150px; height: auto; border-radius: 5px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Atualizar Produto</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>