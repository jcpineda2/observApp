<?php

use App\Livewire\Public\Home;
use App\Livewire\Public\Indicators\Index;
use App\Livewire\Public\Indicators\Domestic;

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Public\Home::class)->name('public.home');

Route::prefix('indicadores')->group(function () {
    Route::get('/turismo-receptivo', \App\Livewire\Public\InboundDashboard::class)->name('public.inbound');
    Route::get('/turismo-interno', \App\Livewire\Public\DomesticDashboard::class)->name('public.domestic');
});
