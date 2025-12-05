<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaltaController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\CandidaturaController;

Route::get('', [UserController::class, 'welcome'])->name('welcome');
Route::get('/info', [UserController::class, 'info'])->name('info');
Route::get('/courses', [UserController::class, 'courses'])->name('courses');
Route::get('/contact', [UserController::class, 'contact'])->name('contact');
Route::get('/eventos', [EventController::class, 'index'])->name('eventos');

Route::post('/login', [UserController::class, 'loginPost'])->name('login.post');

Route::get('/candidaturas/create', [CandidaturaController::class, 'create'])->name('candidaturas.create');
Route::post('/candidaturas', [CandidaturaController::class, 'store'])->name('candidaturas.store');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('storeuser');

Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
route::get('/grade', [SettingsController::class, 'grade'])->name('grade');
Route::post('/store-grade', [SettingsController::class, 'store'])->name('store.grade');

route::get('/licenciatura', [CourseController::class, 'licenciatura'])->name('courses.licenciatura');
route::get('/ctesp', [CourseController::class, 'ctesp'])->name('courses.ctesp');
route::get('/posgraduacao', [CourseController::class, 'posgraduacao'])->name('courses.posgraduacao');

route::get('/ctesp-dm', [CourseController::class, 'dm'])->name('dm');
route::get('/ctesp-dmm', [CourseController::class, 'dmm'])->name('dmm');
route::get('/ctesp-ds', [CourseController::class, 'ds'])->name('ds');
route::get('/ctesp-ig', [CourseController::class, 'ig'])->name('ig');
route::get('/ctesp-ria', [CourseController::class, 'ria'])->name('ria');
route::get('/ctesp-rs', [CourseController::class, 'rs'])->name('rs');
route::get('/ctesp-ss', [CourseController::class, 'cs'])->name('cs');

route::get('/licenciatura-informatica', [CourseController::class, 'informatica'])->name('informatica');
route::get('/licenciatura-multimedia', [CourseController::class, 'multimedia'])->name('multimedia');

route::get('/mestrado-business', [CourseController::class, 'business'])->name('business');
route::get('/mestrado-cloud', [CourseController::class, 'cloud'])->name('cloud');

Route::get('/faltas', [FaltaController::class, 'index'])->name('faltas.index');
Route::get('/faltas/alunos', [FaltaController::class, 'alunos']);
Route::get('/faltas/disciplina/{disciplinaId}', [FaltaController::class, 'faltasPorDisciplina']);
Route::post('/professor/faltas', [FaltaController::class, 'store']);

Route::get('/pagamentos', [PagamentoController::class, 'pay'])->name('pay');
Route::post('/pagamentos/finalizar', [PagamentoController::class, 'complete'])->name('complete');

Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.edit');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.update');

Route::get('/staionery', [SettingsController::class, 'staionery'])->name('staionery');
Route::get('/drink', [SettingsController::class, 'drink'])->name('drink');

Route::get('/food', [LetterController::class, 'letter'])->name('letter');
Route::get('/letter/create', [LetterController::class, 'create'])->name('letter.create');
Route::post('/letter/store', [LetterController::class, 'store'])->name('letter.store');
Route::get('/letter/{id}', [LetterController::class, 'show'])->name('letter.show');

Route::get('/sproducts', [SettingsController::class, 'products'])->name('products');
Route::get('/saldo/recarregar', [SaldoController::class, 'saldo'])->name('saldo.recarregar');
Route::post('/saldo/recarregar', [SaldoController::class, 'recarregar'])->name('saldo.recarregar');
Route::post('/produto/adquirir/{id}', [SaldoController::class, 'adquirir'])->name('produto.adquirir');

Route::fallback(function() {
    return view('fallback');
});