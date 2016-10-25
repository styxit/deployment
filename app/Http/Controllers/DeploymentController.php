<?php

namespace App\Http\Controllers;

class DeploymentController extends Controller
{
    /**
     * List all github deployments for a users repositories.
     *
     * @return Response
     */
    public function index()
    {
        // Get all repositories for the user.
        $repositories = collect($this->github->me()->repositories());

        $deployments = collect([]);
        $repositories->each(function(&$repo) use (&$deployments) {
            try {
                // Collect all deployments for repository and merge with other deployments.
                $deployments = $deployments->merge(
                    collect($this->github->deployment()->all($repo['owner']['login'], $repo['name']))
                );
            } catch (\Github\Exception\RuntimeException $e) {
                // Continue on runtime exceptions.
                return;
            }
        });

        return view(
            'deployments.index',
            [
                'deployments' => $deployments->sortByDesc('created_at'),
            ]
        );
    }
}
