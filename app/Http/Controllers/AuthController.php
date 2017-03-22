<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Two\User as SocialiteUser;
use Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->scopes(['repo_deployment', 'read:org', 'repo'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('github')->scopes(['repo_deployment', 'read:org', 'repo'])->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }

        // Store the user details from socialite.
        $authUser = $this->updateOrCreateUser($user);

        // Immediately log the user in.
        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    /**
     * Update existing user or create a new user.
     *
     * @param SocialiteUser $socialiteUser The user details to store.
     *
     * @return User The user model.
     */
    private function updateOrCreateUser(SocialiteUser $socialiteUser)
    {
        // Update user details or create a new user.
        return User::updateOrCreate(
            [
                'github_id' => $socialiteUser->getId(),
            ],
            [
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'login' => $socialiteUser->getNickname(),
                'avatar' => $socialiteUser->getAvatar(),
                'token' => $socialiteUser->token
            ]
        );
    }

    /**
     * Destroy the user session and return to the homepage.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();

        return Redirect::to('/');
    }
}
