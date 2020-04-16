<?php

namespace App\Providers;

use App\ClientProfileQuestion;
use App\GeneralInfoQuestion;
use App\Observers\ClientProfileQuestionObserver;
use App\Observers\GeneralInfoQuestionObserver;
use App\Observers\ProjectObserver;
use App\Observers\SizingQuestionObserver;
use App\Observers\UserObserver;
use App\Observers\VendorProfileQuestionObserver;
use App\Project;
use App\SizingQuestion;
use App\User;
use App\VendorProfileQuestion;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
        User::observe(UserObserver::class);
        GeneralInfoQuestion::observe(GeneralInfoQuestionObserver::class);
        SizingQuestion::observe(SizingQuestionObserver::class);
        ClientProfileQuestion::observe(ClientProfileQuestionObserver::class);
        VendorProfileQuestion::observe(VendorProfileQuestionObserver::class);

        Blade::directive('logo', function () {
            return "<?php echo url('/assets/images/techadvisory-logo.png'); ?>";
        });

        Blade::directive('profilePic', function () {
            return "<?php echo url('/assets/images/user.png'); ?>";
        });
        Blade::directive('year', function () {
            return "<?php echo date('Y'); ?>";
        });
    }
}
