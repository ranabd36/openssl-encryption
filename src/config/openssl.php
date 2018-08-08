<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public Key Paths
    |--------------------------------------------------------------------------
    | Here you may specify the public path. This is required for encrypt data.
    | Remember that this encrypted data can be decrypted who got the paired
    | private key.
    |
    */

    'public_key_path' => '',

    /*
    |--------------------------------------------------------------------------
    | Private Key Path
    |--------------------------------------------------------------------------
    | Here you may specify the private path. This is required for decrypt data.
    | Make sure that the data need to decrypt must be encrypted with the paired
    | public key.
    |
    */

    'private_key_path' => '',

    /*
    |--------------------------------------------------------------------------
    | Passphrases
    |--------------------------------------------------------------------------
    | This is optional configuration. If you don't feel enough secure then you
    | can set the passpharse. It will need when you decrypt the data.
    |
    */

    'passphrase' => '',

];