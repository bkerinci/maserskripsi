<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                // If exists, just update their google_id
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                $isNewUser = true;
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    // We generate a random password for Google-registered users 
                    // or we could leave it null, but since we set it to nullable it's fine.
                    // Actually, setting a random password is safer for some legacy auth checks.
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(), // Assume Google verified their email
                ]);
            }

            Auth::login($user, true);

            if ($isNewUser) {
                return redirect()->to('/');
            }

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Gagal login menggunakan Google. Silakan coba lagi.']);
        }
    }
}
