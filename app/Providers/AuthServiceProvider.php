<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\UserType' => 'App\Policies\UserTypePolicy',
        'App\Models\Slider' => 'App\Policies\SliderPolicy',
        'App\Models\Faq' => 'App\Policies\FaqPolicy',
        'App\Models\Announcement' => 'App\Policies\AnnouncementPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
