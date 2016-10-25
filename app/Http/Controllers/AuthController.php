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

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    /**
     * Return user if exists; create and return if doesn't.
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }

        return User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'login' => $githubUser->user['login'],
            'avatar' => $githubUser->avatar,
            'token' => $githubUser->token
        ]);
    }
}
