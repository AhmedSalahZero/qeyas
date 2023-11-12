<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Exam' => 'App\Policies\ExamPolicy',
        'App\Course' => 'App\Policies\CoursePolicy',
        'App\Book' => 'App\Policies\BookPolicy',
        'App\BookRequest' => 'App\Policies\BookRequestPolicy',
        'App\ExamRequest' => 'App\Policies\ExamRequestPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
