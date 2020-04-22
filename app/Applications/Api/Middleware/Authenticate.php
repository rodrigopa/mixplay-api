<?php

namespace App\Applications\Api\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Http\Middleware\Authenticate as JWTAuthenticate;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTAuth;

class Authenticate extends JWTAuthenticate
{

    public function handle($request, Closure $next)
    {
        $this->authenticate($request);
        $issuedAt = auth('api')
            ->getPayload()
            ->getClaims()
            ->get('iat')
            ->getValue();

        $passwordUpdatedAt = auth('api')
            ->user()
            ->password_changed_at
            ->timestamp;

        // check password
        if ($passwordUpdatedAt > $issuedAt) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token not provided');
        }

        return $next($request);
    }

}
