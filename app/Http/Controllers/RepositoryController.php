<?php

namespace App\Http\Controllers;

class RepositoryController extends Controller
{
    /**
     * List github repositories.
     *
     * @return Response
     */
    public function index()
    {
        $repositories = collect($this->github->me()->repositories());

        // Sort repositories case insensitive.
        $repositories = $repositories->sortBy(function ($repository, $key) {
            return strtolower($repository['name']);
        });

        return view(
            'repositories.index',
            [
                'repositories' => $repositories,
            ]
        );
    }

    /**
     * List github repositories for an organization.
     *
     * @return Response
     */
    public function organization($organizationId)
    {
        // Get organization by id.
        $organization = $this->github->organizations()->show($organizationId);

        // Get all repositories for organization.
        $repositories = collect($this->github->organization($organizationId)->repositories($organizationId));

        // Sort repositories case insensitive.
        $repositories = $repositories->sortBy(function ($repository, $key) {
            return strtolower($repository['name']);
        });

        return view(
            'repositories.organization',
            [
                'repositories' => $repositories,
                'organization' => $organization,
            ]
        );
    }
}
