<?php 
namespace Georgehadjisavva\ElevenLabsClient\Providers;

use Georgehadjisavva\ElevenLabsClient\ElevenLabsClient;
use Illuminate\Support\ServiceProvider;

class ElevenLabsClientServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/elevenlabs-client.php', 'elevenlabs-client');

   

    }

    public function boot()
    {
        $this->app->singleton(ElevenLabsClient::class, function ($app) {
            $apiKey = config('elevenlabs-client.api_token'); 
     
            return new ElevenLabsClient($apiKey);
        });

        $this->publishes([
            __DIR__.'/../config/elevenlabs-client.php' => config_path('elevenlabs-client.php'),
        ], 'config');
    }
    

}


