<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Transaksi;
use App\Observers\TransaksiObserver;

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
        Log::info('🔧 AppServiceProvider boot() dieksekusi');

        Transaksi::creating(function($trx){
        Log::info('🟡 Event creating() fired', ['tmp' => true]);
        });

        Transaksi::observe(TransaksiObserver::class);
        Log::info('✅ Observer didaftarkan');

        View::composer('*', function ($view) {
        $view->with('authUser', Auth::guard('user')->user());
    });
    }
}
