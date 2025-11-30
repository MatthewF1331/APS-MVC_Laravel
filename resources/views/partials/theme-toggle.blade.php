{{-- REQUISITO 5: Controle de Tema com Cookie, componente reutilizável --}}
<form action="{{ url('/categorias/set-theme') }}" method="POST" class="d-inline">
    @csrf
    @if ($theme === 'dark')
        <input type="hidden" name="theme" value="light">
        <button type="submit" class="btn btn-sm btn-light">Modo Claro</button>
    @else
        <input type="hidden" name="theme" value="dark">
        <button type="submit" class="btn btn-sm btn-dark">Modo Escuro</button>
    @endif
</form>