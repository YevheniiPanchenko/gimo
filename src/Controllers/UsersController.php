<?php

namespace Src\Controllers;

use Src\Models\User;
use Src\System\JWT;
use Src\System\Request;
use Src\Traits\Validation;

class UsersController extends Controller
{
    use Validation;

    public function login(Request $request): string
    {
        $data = $request->getBody();
        $validation = $this->validate($data, [
            'email' => ['required', 'min' => 4, 'max' => 10, 'string'],
            'password' => ['required', 'min' => 4, 'string']
        ]);
        if (!empty($validation)) {
            $this->validationErrorResponse($validation);
        }
        $user = User::where('email', $data['email']);
        if (!$user) {
            return $this->notFoundResponse();
        }
        $verify = $this->verified($data['password'], $user->password);
        if (!$verify) {
            return $this->unauthorizedResponse('email or password are wrong');
        }
        $token = JWT::encode($data);
        return $this->successResponse([
            'token' => $token
        ], 'Token');
    }

    private function verified($password, $hash): bool
    {
        if (password_verify($password, $hash)) {
            return true;
        }
        return false;
    }
}