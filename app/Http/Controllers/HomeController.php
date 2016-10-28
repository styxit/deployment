<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Dashboard.
     * List all the user's organizations.
     *
     * @return Response
     */
    public function index()
    {
        // Get a list of all organizations the user belongs to.
        $organizations = collect($this->github->me()->organizations());

        // Update organizations with more details.
        $organizations = $organizations->map(function($organization, $key) {
            return $this->github->organizations()->show($organization['login']);
        })->sortBy('name');

        return view(
            'home',
            [
               'organizations' => $organizations,
            ]
        );
    }
}
