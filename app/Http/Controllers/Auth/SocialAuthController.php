<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                // If user exists, update their google_id and login
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                    ]);
                }
                
                // If email is not verified but logging in via Google, we can verify it
                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                Auth::login($user);
            } else {
                $isNewUser = true;
                // If user does not exist, create a new one
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'password' => bcrypt(Str::random(16)), // Dummy password
                    'role' => 'user',
                ]);
                
                // Automatically verify email since it's from Google
                $user->markEmailAsVerified();
                
                event(new Registered($user));

                Auth::login($user);
            }

            if ($isNewUser) {
                return redirect()->to('/');
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['google' => 'Gagal login menggunakan Google. Silakan coba lagi.']);
        }
    }
}
