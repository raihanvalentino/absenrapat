<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Agar tombol halaman (1, 2, 3...) menggunakan gaya Tailwind CSS
        Paginator::useTailwind();

        // 2. Registrasi Livewire (Biarkan jika Anda memang menggunakan Livewire di halaman lain)
        // Pastikan class component-nya benar-benar ada.
        Livewire::component('multi-step-form', \App\Http\Livewire\MultiStepForm::class);
    }

    
}