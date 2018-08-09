<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 8/9/18
 * Time: 12:26 PM
 */

namespace OpenSSLEncryption;


use OpenSSLEncryption\Exceptions\OpenSSLException;

trait ErrorHandler
{
    /**
     * @param $message
     * @throws OpenSSLException
     */
    public function exception($message)
    {
        throw new OpenSSLException($message);
    }
}