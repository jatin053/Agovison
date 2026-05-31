<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        Model::unguard();

        Gate::before(static function ($user, string $ability) {
            return method_exists($user, 'hasRole') && $user->hasRole('Admin') ? true : null;
        });

        View::composer('*', static function ($view) {
            $settings = collect();

            if (Schema::hasTable('settings')) {
                $settings = Setting::query()
                    ->where('is_public', true)
                    ->pluck('value', 'key');
            }

            $view->with('publicSettings', $settings);
            $view->with('availableLocales', [
                'en' => 'English',
                'hi' => 'Hindi',
            ]);
            $view->with('currentLocale', app()->getLocale());
        });
    }
}
