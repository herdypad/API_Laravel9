<?php

namespace App\Providers;

use Tymon\JWTAuth\Providers\Auth\AuthInterface;

class MyCustomAuthenticationProvider implements AuthInterface
{
    public function byCredentials(array $credentials = [])
    {
        return $credentials['username'] == env('USERNAME') && $credentials['password'] == env('PASSWORD');
    }

    public function byId($id)
    {
        // maybe throw an expection?
    }

    public function user()
    {
        // you will have to implement this maybe.
    }
}
