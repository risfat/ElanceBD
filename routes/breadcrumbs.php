<?php
/**
 * Breadcrumbs registration
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
Breadcrumbs::for(
    'home', function ($trail) {
        $trail->push('Home', route('home'));
    }
);

Breadcrumbs::for(
    'jobs', function ($trail) {
        $trail->parent('home');
        $trail->push('Jobs', route('jobs'));
    }
);

Breadcrumbs::for(
    'jobDetail', function ($trail, $slug) {
        $trail->parent('jobs');
        $trail->push('Job Detail', route('jobDetail', ['slug' => $slug]));
    }
);

Breadcrumbs::for(
    'createProposal', function ($trail, $slug) {
        $trail->parent('jobDetail', $slug);
        $trail->push('Job Proposal', route('createProposal', ['job_slug' => $slug]));
    }
);

Breadcrumbs::for(
    'employerJobs', function ($trail, $slug) {
        $trail->parent('jobs');
        $trail->push('Employer Jobs', route('employerJobs', ['slug' => $slug]));
    }
);

Breadcrumbs::for(
    'searchResults', function ($trail) {
        $trail->parent('home');
        $trail->push('Search Results', route('searchResults'));
    }
);

Breadcrumbs::for(
    'showPage', function ($trail, $page, $slug) {
        $trail->parent('home');
        if (!empty($page)) {
            $trail->push($page->title, route('showPage', ['slug' => $slug]));
        }
    }
);

Breadcrumbs::for(
    'userListing', function ($trail) {
        $trail->parent('home');
        $trail->push('Users', route('userListing'));
    }
);

Breadcrumbs::for(
    'showUserProfile', function ($trail, $slug) {
        $trail->parent('home');
        $trail->push('Profile', route('showUserProfile', ['slug' => $slug]));
    }
);


