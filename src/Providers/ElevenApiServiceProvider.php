<?php 
namespace Georgehadjisavva\ElevenApiClient\Providers;

use Georgehadjisavva\ElevenApiClient\ElevenApiClient;
use Illuminate\Support\ServiceProvider;

class ElevenApiServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/elevenlabs-client.php', 'elevenlabs-client');

        $this->app->singleton('ElevenClient', function ($app) {
            return new ElevenApiClient($app['config']['eleven-api.api_key']);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/elevenlabs-client.php' => config_path('elevenlabs-client.php'),
        ], 'config');
    }
    

}


