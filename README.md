# OpenSSL Encryption
Secure Laravel OpenSSL Public Key/Private Key Encryption Library.


## Introduction
OpenSSL Encryption is laravel public/private key pair encryption package. Which allow you to generate public/private key and encrypt and decrypt data with that public/private key. 

You want to send/receive secure message to your friends. Then you have to generate public/private key and send the public key to your friends. Now one of your friends encrypt the message with your given public key and send it to you. You receive the message and decrypt the message with your private key. 

If any attacker found the message but the attacker could not decrypt it without your private key. So don't share your private key with anyone. 



## Install (Laravel)
Install via composer
```
composer require ranabd36/openssl-encryption:1.0.0
```
The package is auto-discovered and registered by default, but if you want to register it yourself:

Add service provider to `config/app.php` in `providers` section.
```php
OpenSSLEncryption\Providers\OpenSSLEncryptionServiceProvider::class,
```
Add alias to `config/app.php` in `alias` section.
```php
OpenSSLEncryption\OpenSSL::class,
```

To publish the config, run the vendor publish command:
```
php artisan vendor:publish \ --provider="OpenSSLEncryption\Providers\OpenSSLEncryptionServiceProvider"
``` 


## License

OpenSSL Encryption is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

