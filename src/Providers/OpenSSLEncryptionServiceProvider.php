<?php

namespace OpenSSLEncryption\Providers;

use Illuminate\Support\ServiceProvider;
use OpenSSLEncryption\Commands\KeyGenerateCommand;
use OpenSSLEncryption\Services\Encrypter;

class OpenSSLEncryptionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/openssl.php' => config_path('openssl.php'),
        ]);

        $this->app->bind('OpenSSL', function () {
            $publicPath = config('openssl.public_key_path');
            $privatePath = config('openssl.private_key_path');
            $passPhrase = config('openssl.passphrase');
            return new Encrypter($privatePath, $publicPath, $passPhrase);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                KeyGenerateCommand::class,
            ]);
        }
    }
}
