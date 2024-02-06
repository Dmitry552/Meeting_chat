<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use App\Models\Interlocutor;

class PrivateChannel
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $code = !$request->header('InterlocutorCode') ?: $request->header('InterlocutorCode');

        if ($this->auth->guard('interlocutor')->check()) {
            $this->auth->shouldUse('interlocutor');
        } elseif ($code) {
            $interlocutor = $this->getInterlocutor($code);
            $this->authenticateInterlocutor($interlocutor);
        }

        return $next($request);
    }

    private function getInterlocutor(string $code): Authenticatable
    {
        /** @var Authenticatable $interlocutor */
        $interlocutor = Interlocutor::query()
            ->where('code', $code)->first();

        return $interlocutor;
    }

    private function authenticateInterlocutor(Authenticatable $interlocutor): void
    {
        $this->auth->guard('interlocutor')->login($interlocutor);
        $this->auth->shouldUse('interlocutor');
    }
}
