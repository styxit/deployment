<?php

namespace App\Http\Controllers;

use Github\ResultPager;

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

    /**
     * Show details of a deployment including the statuses.
     *
     * @return Response
     */
    public function show($repositoryLogin, $repositoryName, $deploymentId)
    {
        // Get repository details.
        $repository = $this->github->repositories()->show($repositoryLogin, $repositoryName);
        // Get a specific deployment.
        $deployment = $this->github->deployments()->show($repositoryLogin, $repositoryName, $deploymentId);
        // Get all statuses for the deployment, using the ResultPager.
        $statuses  = collect(app(ResultPager::class, [$this->github])->fetchAll(
            $this->github->deployments(),
            'getStatuses',
            [$repositoryLogin, $repositoryName, $deploymentId]
        ));

        return view(
            'deployments.show',
            [
                'deployment' => $deployment,
                'repository' => $repository,
                'statuses' => $statuses->sortByDesc('created_at'),
            ]
        );
    }
}
