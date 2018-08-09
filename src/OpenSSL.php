<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 8/8/18
 * Time: 6:12 PM
 */

namespace OpenSSLEncryption;


use Illuminate\Support\Facades\Facade;

class OpenSSL extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'OpenSSL';
    }
}