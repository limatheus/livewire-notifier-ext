<?php

namespace CodeSPB\LivewireNotifier;

use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use CodeSPB\LivewireNotifier\Http\Livewire\Notifier;
use CodeSPB\LivewireNotifier\Http\Livewire\NotifierMessage;

class LivewireNotifierServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'codemotion');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'codemotion');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        Livewire::component('notifier', Notifier::class);
        Livewire::component('notifier-message', NotifierMessage::class);
        // Blade::component('livewire-notifier::components.message', 'notifier-message');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-notifier');
        // $this->callAfterResolving(BladeCompiler::class, function () {
        // });
    }
    
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // $this->app->afterResolving(BladeCompiler::class, function () {
        //     Livewire::component('notifier', Notifier::class);
        // });
        $this->mergeConfigFrom(__DIR__.'/../config/livewire-notifier.php', 'livewire-notifier');

        // Register the service the package provides.
        $this->app->singleton('livewire-notifier', function ($app) {
            return new LivewireNotifier;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['livewire-notifier'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/livewire-notifier.php' => config_path('livewire-notifier.php'),
        ], 'livewire-notifier.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/codespb'),
        ], 'livewire-notifier.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/codespb'),
        ], 'livewire-notifier.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/codespb'),
        ], 'livewire-notifier.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
