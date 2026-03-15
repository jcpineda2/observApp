<?php

use App\Livewire\Public\AccommodationPage;
use App\Livewire\Public\ConnectivityPage;
use App\Livewire\Public\DomesticTourismPage;
use App\Livewire\Public\EmploymentPage;
use App\Livewire\Public\Home;
use App\Livewire\Public\InboundTourismPage;
use App\Livewire\Public\ProvidersPage;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function (): void {
    Route::get('/', Home::class)->name('home');
    Route::get('/turismo-interno', DomesticTourismPage::class)->name('domestic');
    Route::get('/turismo-receptivo', InboundTourismPage::class)->name('inbound');
    Route::get('/prestadores', ProvidersPage::class)->name('providers');
    Route::get('/alojamientos', AccommodationPage::class)->name('accommodation');
    Route::get('/empleo', EmploymentPage::class)->name('employment');
    Route::get('/conectividad', ConnectivityPage::class)->name('connectivity');
});
