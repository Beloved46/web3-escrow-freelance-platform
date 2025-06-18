<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('Super Admin') ? true : null;
        // });
        
        // Gate::define('viewPulse', function (User $user) {
        //     return $user->hasRole(RoleEnum::SUPERADMIN);
        // });

        $this->configureCommands();
        $this->configureModels();
        $this->configureUrl();
        // $this->passwordDefaults();
        // $this->filamentShieldConfigs();
    }

    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict();
        Model::unguard();

    }

    /**
     * Configure the application's URL.
     */
    private function configureUrl(): void
    {
        if ($this->app->environment('production') || $this->app->environment('development')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Configure the default password settings.
     */
    // private function passwordDefaults()
    // {
    //     Password::defaults(function () {
    //         return Password::min(8);
    //         // ->letters()
    //         // ->numbers()
    //         // ->symbols()
    //         // ->mixedCase()
    //         // ->uncompromised();
    //     });
    // }

    /**
     * Configure filaments shield for admin.
     */
    // private function filamentShieldConfigs()
    // {
    //     // individually prohibit commands
    //     Commands\SetupCommand::prohibit($this->app->isProduction());
    //     Commands\InstallCommand::prohibit($this->app->isProduction());
    //     Commands\GenerateCommand::prohibit($this->app->isProduction());
    //     Commands\PublishCommand::prohibit($this->app->isProduction());
    //     // or prohibit the above commands all at once
    //     FilamentShield::prohibitDestructiveCommands($this->app->isProduction());
    // }
}
