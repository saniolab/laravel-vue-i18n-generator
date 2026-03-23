<?php

namespace Saniolab\VueInternationalizationGenerator;

use Illuminate\Support\ServiceProvider;

class GeneratorProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton('vue-i18n.generate', function () {
            return new Commands\GenerateInclude();
        });

        $this->commands(
            'vue-i18n.generate'
        );

        $this->publishes([
            __DIR__.'/config/vue-i18n-generator.php' => config_path('vue-i18n-generator.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/config/vue-i18n-generator.php',
            'vue-i18n-generator'
        );
    }

    public function register(): void
    {
    }
}
