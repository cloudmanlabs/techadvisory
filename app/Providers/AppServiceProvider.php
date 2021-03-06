<?php

namespace App\Providers;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;
use App\Observers\ClientProfileQuestionObserver;
use App\Observers\ClientProfileQuestionResponseObserver;
use App\Observers\GeneralInfoQuestionObserver;
use App\Observers\GeneralInfoQuestionResponseObserver;
use App\Observers\ProjectObserver;
use App\Observers\SelectionCriteriaQuestionObserver;
use App\Observers\SelectionCriteriaQuestionProjectPivotObserver;
use App\Observers\SelectionCriteriaQuestionResponseObserver;
use App\Observers\SizingQuestionObserver;
use App\Observers\UserCredentialObserver;
use App\Observers\UserObserver;
use App\Observers\VendorApplicationObserver;
use App\Observers\VendorProfileQuestionObserver;
use App\Observers\VendorProfileQuestionResponseObserver;
use App\Observers\VendorSolutionObserver;
use App\Observers\VendorSolutionQuestionObserver;
use App\Observers\UseCaseTemplateObserver;
use App\Observers\UseCaseQuestionObserver;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionProjectPivot;
use App\SelectionCriteriaQuestionResponse;
use App\SizingQuestion;
use App\User;
use App\UserCredential;
use App\VendorApplication;
use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;
use App\VendorSolution;
use App\VendorSolutionQuestion;
use App\UseCaseTemplate;
use App\UseCaseQuestion;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

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
        UserCredential::observe(UserCredentialObserver::class);
        GeneralInfoQuestion::observe(GeneralInfoQuestionObserver::class);
        SizingQuestion::observe(SizingQuestionObserver::class);
        SelectionCriteriaQuestion::observe(SelectionCriteriaQuestionObserver::class);
        SelectionCriteriaQuestionProjectPivot::observe(SelectionCriteriaQuestionProjectPivotObserver::class);
        ClientProfileQuestion::observe(ClientProfileQuestionObserver::class);
        VendorProfileQuestion::observe(VendorProfileQuestionObserver::class);
        VendorSolutionQuestion::observe(VendorSolutionQuestionObserver::class);
        VendorSolution::observe(VendorSolutionObserver::class);
        VendorApplication::observe(VendorApplicationObserver::class);

        SelectionCriteriaQuestionResponse::observe(SelectionCriteriaQuestionResponseObserver::class);
        VendorProfileQuestionResponse::observe(VendorProfileQuestionResponseObserver::class);

        GeneralInfoQuestionResponse::observe(GeneralInfoQuestionResponseObserver::class);
        ClientProfileQuestionResponse::observe(ClientProfileQuestionResponseObserver::class);

        UseCaseTemplate::observe(UseCaseTemplateObserver::class);
        UseCaseQuestion::observe(UseCaseQuestionObserver::class);

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
