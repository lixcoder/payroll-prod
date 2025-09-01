<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiResponseTrait;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers, ApiResponseTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($this->isAppRequest($request)) {
                return $this->validationErrorResponse($e->errors(), 'Registration failed', $request);
            }
            throw $e;
        }

        $user = $this->create($request->all());

        event(new Registered($user));

        Auth::login($user);

        if ($this->isAppRequest($request)) {
            return $this->authSuccessResponse(
                $user,
                'Registration successful',
                'home',
                $request
            );
        }

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($this->isAppRequest($request)) {
            return $this->authSuccessResponse(
                $user,
                'Registration successful',
                'home',
                $request
            );
        }
        // Default: do nothing, let Laravel handle web redirect
    }

    /**
     * Handle validation errors for API requests
     */
    protected function sendFailedRegistrationResponse(Request $request, array $errors)
    {
        if ($this->isAppRequest($request)) {
            return $this->validationErrorResponse($errors, 'Registration failed', $request);
        }

        return redirect()->back()
            ->withInput($request->only('name', 'email'))
            ->withErrors($errors);
    }
}
