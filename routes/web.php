<?php

use Illuminate\Support\Facades\Route;



// Route::get('/', Home::class)->name('public.home');

Route::view('/','welcome');

// Route::prefix('indicadores')->name('public.')->group(function () {
//     Route::get('/prestadores', ProvidersDashboard::class)->name('providers');
//     Route::get('/turismo-receptivo', InboundDashboard::class)->name('inbound');
//     Route::get('/turismo-interno', DomesticDashboard::class)->name('domestic');

//     // cuando lleguemos:
//     // Route::get('/alojamientos', \App\Livewire\Public\AccommodationsDashboard::class)->name('accommodations');
//     // Route::get('/empleo', \App\Livewire\Public\EmploymentDashboard::class)->name('employment');
//     // Route::get('/conectividad', \App\Livewire\Public\ConnectivityDashboard::class)->name('connectivity');
// });
