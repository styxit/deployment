<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Redirect;
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

        // Store the user details received from GitHub.
        $authUser = $this->updateOrCreateUser($user);

        // Immediately log the user in.
        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    /**
     * Update existing user or create a new user.
     *
     * @param $githubUser
     * @return User
     */
    private function updateOrCreateUser($githubUser)
    {
        // Update user details or create a new user.
        return User::updateOrCreate(
            [
                'github_id' => $githubUser->id,
            ],
            [
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'login' => $githubUser->user['login'],
                'avatar' => $githubUser->avatar,
                'token' => $githubUser->token
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
