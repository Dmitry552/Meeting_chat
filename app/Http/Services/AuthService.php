<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseAuthService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGuard(): string
    {
        return 'user';
    }

    public function login(User|array $data): JsonResponse | array
    {
        if ($data instanceof User) {
            $token = JWTAuth::fromUser($data);

            return $this->respondWithToken($token);
        }

        $remember_me = $data['remember_me'];
        $data = Arr::except($data, 'remember_me');

        if ($remember_me) {
            auth($this->guard)->factory()->setTTL(20160);
            $token = auth($this->guard)->attempt($data, $remember_me);
        } else {
            $token = auth($this->guard)->attempt($data);
        }

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($this->respondWithToken($token));
    }

    public function logout(): JsonResponse
    {
        auth($this->guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function forgotPassword(array $data): JsonResponse
    {
        $status = Password::sendResetLink($data);

        return $status == Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)]);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function resetPassword(array $data): JsonResponse
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)]);
    }

    public function getSocialUserData(array $data): array
    {
        $provider = $data['provider'];
        $token = $data['token'] ?? null;
        $code = $data['code'] ?? null; //TODO: Add code processing

        /**
         * @var AbstractUser $providerUser
         */
        $providerUser = Socialite::driver($provider)->stateless()->userFromToken($token);

        return [
            'id' => $providerUser->getId(),
            'email' => $providerUser->getEmail(),
            'name' => $providerUser->getName(),
            'avatar' => $providerUser->getAvatar(),
            'raw' => $providerUser->getRaw(),
        ];
    }
}
