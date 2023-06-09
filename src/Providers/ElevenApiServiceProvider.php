<?php 
namespace Georgehadjisavva\ElevenApiClient\Providers;

use Georgehadjisavva\ElevenApiClient\ElevenApiClient;
use Illuminate\Support\ServiceProvider;

class ElevenApiServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/elevenlabs-client.php', 'elevenlabs-client');

   

    }

    public function boot()
    {
        $this->app->singleton(ElevenApiClient::class, function ($app) {
            $apiKey = config('elevenlabs-client.api_token'); 
     
            return new ElevenApiClient($apiKey);
        });

        $this->publishes([
            __DIR__.'/../config/elevenlabs-client.php' => config_path('elevenlabs-client.php'),
        ], 'config');
    }
    

}


