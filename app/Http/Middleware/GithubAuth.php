<?php

namespace App\Http\Middleware;

use Closure;
use Github\Exception\RuntimeException;
use Illuminate\Http\Request;

class GithubAuth
{
    /**
     * Handle the given request.
     * Redirect to logout on Github "Bad credentials" RuntimeException.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Catch Github "Bad credentials" RuntimeException and redirect.
        if (
            !empty($response->exception)
            && $response->exception instanceof RuntimeException
            && $response->exception->getMessage() === 'Bad credentials'
        ) {
            return redirect('logout');
        }

        return $response;
    }
}
