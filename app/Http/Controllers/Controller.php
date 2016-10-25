<?php

namespace App\Http\Controllers;

use Auth;
use GrahamCampbell\GitHub\GitHubFactory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var GitHubFactory Reference to the GitHub connection with token from authenticated user.
     */
    protected $github;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        // Run middleware to set github token for authenticated users.
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->github = app(GitHubFactory::class)->make(
                    [
                        'token' => Auth::user()->token,
                        'method' => 'token',
                        'cache' => false
                    ]
                );
            }

            return $next($request);
        });
    }
}
