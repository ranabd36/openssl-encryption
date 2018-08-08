<?php

namespace Ranabd36\OpenSSLEncryption\Commands;

use Illuminate\Console\Command;

class KeyGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openssl:key-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate public key private key.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $prefix = null;
        $passPhrase = '';
        $path = $this->ask('Enter the path where you want to generate your key');

        if($this->confirm('Do you want add prefix to your key name?')){
            $prefix = $this->ask('Enter the prefix of your key or leave it blank');
        }

        if($this->confirm('Do you want more secure with passphrase?')){
            $passPhrase = $this->ask('Enter the passphrase to more secure or leave it blank');
        }

        if (!is_dir($path)) {
            $this->error('Directory does not exits.');
        }

        $privateKey = openssl_pkey_new(array(
            'private_key_bits' => 4096,      // Size of Key.
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ));
        if (is_null($prefix)) {
            $privateKeyPath = $path . '/private.key';
            $publicKeyPath = $path . '/public.key';
        } else {
            $privateKeyPath = $path . '/' . $prefix . '-private.key';
            $publicKeyPath = $path . '/' . $prefix . '-public.key';
        }

        // Save the private key to private.key file. Never share this file with anyone.
        if(empty($passPhrase)){
            openssl_pkey_export_to_file($privateKey, $privateKeyPath);
        }else{
            openssl_pkey_export_to_file($privateKey, $privateKeyPath, $passPhrase);
        }
        chmod($privateKeyPath, 0777);
        // Generate the public key for the private key
        $a_key = openssl_pkey_get_details($privateKey);
        // Save the public key in public.key file. Send this file to anyone who want to send you the encrypted data.
        file_put_contents($publicKeyPath, $a_key['key']);
        chmod($publicKeyPath, 0777);

        // Free the private Key.
        openssl_free_key($privateKey);

        $this->info("Key generated successfully. Never share the private key with anyone.");
    }
}
