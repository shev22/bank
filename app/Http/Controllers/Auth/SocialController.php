<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->createOrUpdateUser($user, 'google');
        return redirect()->route('dashboard');
    }

    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->createOrUpdateUser($user, 'github');
        return redirect()->route('dashboard');
    }

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->createOrUpdateUser($user, 'facebook');
        return redirect()->route('dashboard');
    }

    private function createOrUpdateUser($data, $provider)
    {
        // dd($data->id);
        $user = User::where('email', $data->email)->first();

        if ($user) {
            $user->update([
                'image' => $data->getAvatar(),
                'provider' => $provider,
                'provider_id' => $data->getId(),
            ]);
        } else {
            $user = User::create([
                'name' => $data->getName(),
                'email' => $data->getEmail(),
                'image' => $data->getAvatar(),
                'provider' => $provider,
                'provider_id' => $data->getId(),
            ]);
        }

        Auth::login($user);
    }
}
