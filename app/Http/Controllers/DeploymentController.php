<?php

namespace App\Http\Controllers;

use Github\Exception\RuntimeException;
use Github\ResultPager;
use Illuminate\Http\Request;

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
                // Collect all deployments for repository.
                $repoDeployments = collect($this->github->deployment()->all($repo['owner']['login'], $repo['name']));

                // Add repository details to the deployments.
                $repoDeployments = $repoDeployments->map(function($item, $key) use ($repo){
                    $item['repository'] = $repo;
                    return $item;
                });

                // Merge deployments for this repo with the other deployments.
                $deployments = $deployments->merge($repoDeployments);
            } catch (RuntimeException $e) {
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
        $statuses  = collect(app()->makeWith(ResultPager::class, ['client' => $this->github])->fetchAll(
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

    /**
     * Show form to create a new deployment.
     *
     * @return Response
     */
    public function create($repositoryLogin, $repositoryName)
    {
        // Get repository details.
        $repository = $this->github->repositories()->show($repositoryLogin, $repositoryName);

        // Get all branches for the repository, using the ResultPager.
        $branches  = collect(app()->makeWith(ResultPager::class, ['client' => $this->github])->fetchAll(
            $this->github->repositories(),
            'branches',
            [$repositoryLogin, $repositoryName]
        ))->sortBy(function ($branch) {
            // Order branches by branch name.
            return strtolower($branch['name']);
        });

        return view(
            'deployments.create',
            [
                'branches' => $branches,
                'repository' => $repository,
            ]
        );
    }

    /**
     * Create a new deployment at GitHub.
     *
     * @return Response
     */
    public function store($repositoryLogin, $repositoryName, Request $request)
    {
        try {
            $deployment = $this->github->deployments()->create(
                $repositoryLogin,
                $repositoryName,
                $request->except(['_token'])
            );
        } catch (RuntimeException $e) {
            // Show error on runtime exceptions.
            $request->session()->flash('status.error', $e->getMessage());
            return redirect(request()->headers->get('referer'));
        }

        $request->session()->flash('status.success', 'Deployment created');

        return redirect(sprintf(
            '/deployments/%s/%s/%s',
            $repositoryLogin,
            $repositoryName,
            $deployment['id']
        ));
    }
}
