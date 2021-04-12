<?php

namespace Src\Traits;

use Src\System\JWT;
use Src\System\Request;

trait Auth
{
    use Response;

    public function auth(Request $request)
    {
        $token = $request->getToken();
        if (empty($token)) {
            return false;
        }

        $verify = JWT::verify($token);
        if (!$verify) {
            return false;
        }
        return true;
    }
}