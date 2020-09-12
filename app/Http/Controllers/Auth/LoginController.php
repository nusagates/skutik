<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $name = $user->getName();
        $email = $user->getEmail();

        $u = User::where('email', $email)->first();
        if ($u) {
            Auth::loginUsingId($u->id, true);
        } else {
            $pass = Str::random(8);
            $new_user = User::create([
                'username' => strrev(Carbon::now()->timestamp),
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($pass),
            ]);
            Auth::loginUsingId($new_user->id, true);

        }

        if (request()->has('previous')) {
            $this->redirectTo = request()->get('previous');
        }
        return $this->redirectTo ?? '/home';
    }
}
