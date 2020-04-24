<?php

namespace App\Interfaces\Http\Providers;

use Illuminate\Support\ServiceProvider;
use Tmdb\HttpClient\Plugin\ApiTokenPlugin;
use Tmdb\HttpClient\Plugin\LanguageFilterPlugin;

class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $languagePlugin = new LanguageFilterPlugin('pt-BR');
        $client = $this->app->make('Tmdb\Client');
        $client->getHttpClient()->addSubscriber($languagePlugin);
    }
}
