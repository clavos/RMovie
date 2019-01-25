<?php
/**
 * Created by IntelliJ IDEA.
 * User: clavo
 * Date: 23/01/2019
 * Time: 22:00
 */

namespace App\Services;

use GuzzleHttp\Client;

class TokenService
{
    public function __construct()
    {
    }

    public function getToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
