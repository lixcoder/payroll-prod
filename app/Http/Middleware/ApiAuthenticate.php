<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip authentication for web routes (non-app routes)
        if (!str_starts_with($request->path(), 'app/')) {
            return $next($request);
        }

        // Skip authentication for auth routes
        $authRoutes = ['app/login', 'app/register', 'app/password/email', 'app/password/reset'];
        if (in_array($request->path(), $authRoutes) || str_starts_with($request->path(), 'app/password/')) {
            return $next($request);
        }

        // Get token from Authorization header or api_token parameter
        $token = $this->getTokenFromRequest($request);

        if (!$token) {
            return $this->unauthorizedResponse('Token not provided');
        }

        // Find user by token
        $user = User::where('api_token', hash('sha256', $token))
            ->where('token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return $this->unauthorizedResponse('Invalid or expired token');
        }

        // Set the authenticated user
        Auth::login($user);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }

    /**
     * Get token from request
     */
    private function getTokenFromRequest(Request $request): ?string
    {
        // Check Authorization header (Bearer token)
        $header = $request->header('Authorization');
        if ($header && str_starts_with($header, 'Bearer ')) {
            return substr($header, 7);
        }

        // Check api_token parameter
        return $request->input('api_token');
    }

    /**
     * Return unauthorized response
     */
    private function unauthorizedResponse(string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => [
                'redirect_to' => 'login'
            ],
            'status_code' => 401
        ], 401);
    }
}
