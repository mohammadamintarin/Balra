<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        app()->usePublicPath(realpath(base_path().'/../'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
//        $contacts = Contact::all();
//
//
//        View::share([
//            'contact' => $contacts,
//        ]);
    }
}
