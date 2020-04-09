<?php

namespace App\Providers;

use App\GeneralInfoQuestion;
use App\Observers\GeneralInfoQuestionObserver;
use App\Observers\ProjectObserver;
use App\Observers\SizingQuestionObserver;
use App\Project;
use App\SizingQuestion;
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
        GeneralInfoQuestion::observe(GeneralInfoQuestionObserver::class);
        SizingQuestion::observe(SizingQuestionObserver::class);

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
