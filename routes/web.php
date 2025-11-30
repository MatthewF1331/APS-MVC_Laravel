<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $theme = Cookie::get('user_theme', 'light');
    return view('welcome', ['theme' => $theme]);
});

Route::get('/login', function (Request $request) {
    $theme = Cookie::get('user_theme', 'light');
    return view('login', ['theme' => $theme]);
})->name('login');

Route::post('/login-simple', function (Request $request) {
    $request->validate(['name' => 'required|min:2']);
    $request->session()->put('user_name', $request->name);
    $request->session()->put('is_logged_in', true);
    return redirect('/dashboard')->with('sucesso', 'Login realizado com sucesso! Bem-vindo(a) ' . $request->name);
});

Route::post('/logout', function (Request $request) {
    $request->session()->forget(['user_name', 'is_logged_in']);
    $request->session()->flash('sucesso', 'Logout realizado. Sessão limpa.');
    return redirect()->route('login');
})->name('logout');


Route::get('/dashboard', function (Request $request) {
    if (!$request->session()->get('is_logged_in')) {
        return redirect()->route('login')->with('erro', 'Acesso negado. Por favor, faça o login.');
    }

    $request->session()->put('last_accessed_page', 'Dashboard');

    $last_page = $request->session()->get('last_accessed_page', 'Nenhuma');
    $theme = Cookie::get('user_theme', 'light');
    return view('dashboard', ['last_page' => $last_page, 'theme' => $theme]);
})->name('dashboard');


Route::group(['middleware' => [function (Request $request, Closure $next) {

    if (!$request->session()->get('is_logged_in')) {
        return redirect()->route('login')->with('erro', 'Acesso negado. Por favor, faça o login para acessar os módulos.');
    }
    return $next($request);
}]], function () {

    Route::controller(ProdutoController::class)->group(function () {
        Route::get('/produtos', 'index');
        Route::post('/produtos', 'store');
        Route::get('/produtos/{produto}/edit', 'edit');
        Route::put('/produtos/{produto}', 'update');
        Route::delete('/produtos/{produto}', 'destroy');
    });

    Route::controller(CategoriaController::class)->group(function () {
        Route::get('/categorias', 'index');
        Route::post('/categorias', 'store');
        Route::get('/categorias/{categoria}/edit', 'edit');
        Route::put('/categorias/{categoria}', 'update');
        Route::delete('/categorias/{categoria}', 'destroy');
    });

    Route::post('/set-theme', [CategoriaController::class, 'set_theme']);
});

Route::controller(CategoriaController::class)->group(function () {
    Route::post('/categorias/set-theme', 'set_theme');
});