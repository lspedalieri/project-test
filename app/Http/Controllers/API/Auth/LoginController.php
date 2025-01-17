<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogUserRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    const TOKEN_NAME = 'service-api';

    /**
     * @var Guard
     */
    protected $auth;

    protected $event = 'login';

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(LogUserRequest $logUser)
    {
        /**
         * @var User $user
         */
        $user = User::where('email', $logUser->email)->first();
        if (! $this->auth->validate($logUser->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 'error',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken(self::TOKEN_NAME);

        return response()->json([
            self::TOKEN_NAME => $token->plainTextToken,
            'user' => $user,
            'status' => 'success',
        ]);
    }
}
