<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 7/4/18
 * Time: 5:27 PM
 */

namespace OpenSSLEncryption\Services;


use OpenSSLEncryption\ErrorHandler;
use OpenSSLEncryption\Exceptions\OpenSSLException;

class Encrypter
{
    use ErrorHandler;
    protected $privateKey;
    protected $publicKey;
    protected $passPhrase;

    public function __construct($privateKey, $publicKey, $passPhrase)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->passPhrase = $passPhrase;
    }

    /**
     * @param $value
     * @return array|null|string
     * @throws OpenSSLException
     */
    public function encrypt($value)
    {
        try {
            $encryptionValue = serialize($value);

            // Get the public Key
            if (!$publicKey = openssl_pkey_get_public("file://$this->publicKey")) {
                $this->exception('Invalid public key or does not set yet.');
            }

            $a_key = openssl_pkey_get_details($publicKey);

            // Encrypt the data in small chunks and then combine and send it.
            $chunkSize = ceil($a_key['bits'] / 8) - 11;
            $encryptedValue = '';

            while ($encryptionValue) {
                $chunk = substr($encryptionValue, 0, $chunkSize);
                $encryptionValue = substr($encryptionValue, $chunkSize);
                $encrypted = '';
                if (!openssl_public_encrypt($chunk, $encrypted, $publicKey)) {
                    $this->exception('Failed to encrypt data.');
                }
                $encryptedValue .= $encrypted;
            }
            openssl_free_key($publicKey);
        } catch (\Exception $exception) {
            $this->exception($exception->getMessage());
        }

        return base64_encode($encryptedValue);
    }

    /**
     * @param $value
     * @return mixed
     * @throws OpenSSLException
     */
    public function decrypt($value)
    {
        try {
            $encryptedValue = base64_decode($value);
            // Get the private Key
            $privatePath = "file://$this->privateKey";
            if (!$privateKey = openssl_pkey_get_private($privatePath, $this->passPhrase)) {
                $this->exception('Invalid private key or does not set yet.');
            }

            $a_key = openssl_pkey_get_details($privateKey);

            // Decrypt the data in the small chunks
            $chunkSize = ceil($a_key['bits'] / 8);
            $decryptedValue = '';

            while ($encryptedValue) {
                $chunk = substr($encryptedValue, 0, $chunkSize);
                $encryptedValue = substr($encryptedValue, $chunkSize);
                $decrypted = '';
                if (!openssl_private_decrypt($chunk, $decrypted, $privateKey)) {
                    $this->exception('Failed to decrypt data.');
                }
                $decryptedValue .= $decrypted;
            }
            openssl_free_key($privateKey);
        } catch (\Exception $exception) {
            $this->exception($exception->getMessage());
        }

        return unserialize($decryptedValue);
    }

}


