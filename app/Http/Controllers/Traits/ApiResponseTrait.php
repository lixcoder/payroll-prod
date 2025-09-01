<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;

trait ApiResponseTrait
{
    /**
     * Check if the request is from Flutter app (has /app/ prefix)
     */
    protected function isAppRequest(?Request $request = null): bool
    {
        $request = $request ?: request();
        return str_starts_with($request->path(), 'app/');
    }

    /**
     * Return appropriate response based on request type
     */
    protected function respondWith($data, string $message = 'Success', int $statusCode = 200, ?Request $request = null)
    {
        $request = $request ?: request();

        if ($this->isAppRequest($request)) {
            return $this->jsonResponse($data, $message, $statusCode, $request);
        }

        // For web requests, return the original data (usually a view or redirect)
        return $data;
    }

    /**
     * Handle different types of responses for JSON
     */
    private function jsonResponse($data, string $message, int $statusCode, Request $request)
    {
        // Handle redirects
        if ($data instanceof RedirectResponse) {
            return $this->handleRedirectForJson($data, $request);
        }

        // Handle views
        if ($data instanceof View) {
            return $this->handleViewForJson($data, $message, $statusCode);
        }

        // Handle direct data
        if (is_array($data) || is_object($data)) {
            return response()->json([
                'success' => $statusCode >= 200 && $statusCode < 300,
                'message' => $message,
                'data' => $data,
                'status_code' => $statusCode
            ], $statusCode);
        }

        // Handle string responses
        return response()->json([
            'success' => $statusCode >= 200 && $statusCode < 300,
            'message' => $message,
            'data' => ['content' => $data],
            'status_code' => $statusCode
        ], $statusCode);
    }

    /**
     * Handle redirect responses for JSON
     */
    private function handleRedirectForJson(RedirectResponse $redirect, Request $request)
    {
        $location = $redirect->getTargetUrl();
        $statusCode = $redirect->getStatusCode();

        // Get any flash messages
        $messages = $this->getFlashMessages();

        // Determine if it's a success or error redirect
        $isSuccess = $this->isSuccessRedirect($location, $request);

        return response()->json([
            'success' => $isSuccess,
            'message' => $this->getRedirectMessage($location, $request, $messages),
            'redirect_to' => $this->getRouteFromUrl($location),
            'redirect_url' => $location,
            'messages' => $messages,
            'status_code' => $isSuccess ? 200 : $statusCode
        ], $isSuccess ? 200 : $statusCode);
    }

    /**
     * Handle view responses for JSON
     */
    private function handleViewForJson(View $view, string $message, int $statusCode)
    {
        $viewData = $view->getData();
        $sanitizedData = $this->sanitizeViewData($viewData);

        // Get any flash messages
        $messages = $this->getFlashMessages();

        return response()->json([
            'success' => $statusCode >= 200 && $statusCode < 300,
            'message' => $message,
            'data' => $sanitizedData,
            'messages' => $messages,
            'meta' => [
                'view_name' => $view->name(),
                'timestamp' => now()->toISOString()
            ],
            'status_code' => $statusCode
        ], $statusCode);
    }

    /**
     * Get flash messages from session
     */
    private function getFlashMessages(): array
    {
        $messages = [];

        // Get success messages
        if (Session::has('success')) {
            $messages[] = [
                'type' => 'success',
                'content' => Session::get('success')
            ];
        }

        // Get error messages
        if (Session::has('error')) {
            $messages[] = [
                'type' => 'error',
                'content' => Session::get('error')
            ];
        }

        // Get warning messages
        if (Session::has('warning')) {
            $messages[] = [
                'type' => 'warning',
                'content' => Session::get('warning')
            ];
        }

        // Get info messages
        if (Session::has('info')) {
            $messages[] = [
                'type' => 'info',
                'content' => Session::get('info')
            ];
        }

        // Get validation errors
        if (Session::has('errors')) {
            $errors = Session::get('errors');
            if (is_object($errors) && method_exists($errors, 'toArray')) {
                $messages[] = [
                    'type' => 'validation_errors',
                    'content' => $errors->toArray()
                ];
            }
        }

        return $messages;
    }

    /**
     * Determine if redirect indicates success
     */
    private function isSuccessRedirect(string $location, Request $request): bool
    {
        // Login/auth redirects are usually errors
        if (str_contains($location, 'login') || str_contains($location, 'auth')) {
            return false;
        }

        // Back redirects with errors are usually failures
        if (str_contains($location, 'back') && Session::has('errors')) {
            return false;
        }

        // Success indicators
        $successIndicators = ['home', 'dashboard', 'index', '/employees', '/users'];
        foreach ($successIndicators as $indicator) {
            if (str_contains($location, $indicator)) {
                return true;
            }
        }

        // If we have success message, it's probably successful
        if (Session::has('success')) {
            return true;
        }

        // Default to success for most redirects
        return true;
    }

    /**
     * Get appropriate message for redirect
     */
    private function getRedirectMessage(string $location, Request $request, array $messages): string
    {
        // If we have flash messages, use the first one
        if (!empty($messages)) {
            return $messages[0]['content'];
        }

        // Auth redirects
        if (str_contains($location, 'login')) {
            return 'Authentication required';
        }

        // Success redirects based on HTTP method
        $method = $request->method();
        if ($method === 'POST') {
            return 'Created successfully';
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            return 'Updated successfully';
        } elseif ($method === 'DELETE') {
            return 'Deleted successfully';
        }

        return 'Operation completed successfully';
    }

    /**
     * Extract route name from URL
     */
    private function getRouteFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        return ltrim($path ?? '', '/');
    }

    /**
     * Sanitize view data for JSON response
     */
    private function sanitizeViewData(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            // Skip Laravel internal data
            if (in_array($key, ['__env', 'app', 'obLevel', '__data', '__path'])) {
                continue;
            }

            try {
                if (is_object($value)) {
                    if (method_exists($value, 'toArray')) {
                        $sanitized[$key] = $value->toArray();
                    } elseif (method_exists($value, 'toJson')) {
                        $sanitized[$key] = json_decode($value->toJson(), true);
                    } else {
                        $sanitized[$key] = $this->convertObjectToArray($value);
                    }
                } elseif (is_array($value)) {
                    $sanitized[$key] = $this->sanitizeArray($value);
                } elseif (is_scalar($value) || is_null($value)) {
                    $sanitized[$key] = $value;
                }
            } catch (\Exception $e) {
                // Skip problematic data
                continue;
            }
        }

        return $sanitized;
    }

    /**
     * Convert object to array with error handling
     */
    private function convertObjectToArray($obj): array
    {
        try {
            if (method_exists($obj, 'toArray')) {
                return $obj->toArray();
            }
            return (array) $obj;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Sanitize array recursively
     */
    private function sanitizeArray(array $array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            try {
                if (is_object($value)) {
                    $sanitized[$key] = $this->convertObjectToArray($value);
                } elseif (is_array($value)) {
                    $sanitized[$key] = $this->sanitizeArray($value);
                } elseif (is_scalar($value) || is_null($value)) {
                    $sanitized[$key] = $value;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $sanitized;
    }

    /**
     * Generate access token for user
     */
    protected function generateToken(User $user): string
    {
        $token = Str::random(80);

        // Store token in users table or create a separate tokens table
        $user->update([
            'api_token' => hash('sha256', $token),
            'token_expires_at' => now()->addDays(30)
        ]);

        return $token;
    }

    /**
     * Helper method for authentication success responses
     */
    protected function authSuccessResponse(User $user, string $message = 'Authentication successful', string $redirectTo = 'home', ?Request $request = null)
    {
        $token = $this->generateToken($user);

        $data = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles ?? [],
                'permissions' => $user->permissions ?? []
            ],
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 30 * 24 * 60 * 60, // 30 days in seconds
            'redirect_to' => $redirectTo
        ];

        return $this->respondWith($data, $message, 200, $request);
    }

    /**
     * Helper method for authentication failure responses
     */
    protected function authFailureResponse(string $message = 'Authentication failed', array $errors = [], ?Request $request = null)
    {
        $data = [
            'errors' => $errors,
            'redirect_to' => 'login'
        ];

        return $this->respondWith($data, $message, 401, $request);
    }

    /**
     * Helper method for success responses
     */
    protected function successResponse($data, string $message = 'Success', ?Request $request = null)
    {
        return $this->respondWith($data, $message, 200, $request);
    }

    /**
     * Helper method for error responses
     */
    protected function errorResponse($data, string $message = 'Error', int $statusCode = 400, ?Request $request = null)
    {
        return $this->respondWith($data, $message, $statusCode, $request);
    }

    /**
     * Helper method for validation error responses
     */
    protected function validationErrorResponse(array $errors, string $message = 'Validation failed', ?Request $request = null)
    {
        $data = [
            'errors' => $errors
        ];

        return $this->respondWith($data, $message, 422, $request);
    }
}
