<?php

namespace Dewsign\NovaRepeaterBlocks\Providers;

use Laravel\Nova\Nova;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Illuminate\Database\Eloquent\Relations\Relation;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ImageBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\MarkdownBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextareaBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\CustomViewBlock;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishConfigs();
        $this->bootViews();
        $this->bootAssets();
        $this->bootCommands();
        $this->publishDatabaseFiles();
        $this->registerMorphmaps();
        $this->registerBladeExtensions();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigsPath(),
            'repeater-blocks'
        );

        Nova::resources([
            Repeater::class,
        ]);
    }

    /**
     * Publish configuration file.
     *
     * @return void
     */
    private function publishConfigs()
    {
        $this->publishes([
            $this->getConfigsPath() => config_path('repeater-blocks.php'),
        ], 'config');
    }

    /**
     * Get local package configuration path.
     *
     * @return string
     */
    private function getConfigsPath()
    {
        return __DIR__.'/../Config/repeater-blocks.php';
    }

    /**
     * Register the artisan packages' terminal commands
     *
     * @return void
     */
    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // MyCommand::class,
            ]);
        }
    }

    /**
     * Load custom views
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'nova-repeater-blocks');
        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('views/vendor/nova-repeater-blocks'),
        ]);
    }

    /**
     * Define publishable assets
     *
     * @return void
     */
    private function bootAssets()
    {
        $this->publishes([
            __DIR__.'/../Resources/assets/js' => resource_path('assets/js/vendor/nova-repeater-blocks'),
        ], 'js');
    }

    private function publishDatabaseFiles()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');

        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(
            __DIR__ . '/../Database/factories'
        );

        $this->publishes([
            __DIR__ . '/../Database/factories' => base_path('database/factories')
        ], 'factories');

        $this->publishes([
            __DIR__ . '/../Database/migrations' => base_path('database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../Database/seeds' => base_path('database/seeds')
        ], 'seeds');
    }

    public function registerBladeExtensions()
    {
        Blade::directive('repeaterblocks', function ($expression) {
            return "<?php echo \Dewsign\NovaRepeaterBlocks\Support\RenderEngine::renderRepeaters({$expression}); ?>";
        });

        Blade::directive('repeaterjson', function ($expression) {
            return "<?php echo json_encode(\Dewsign\NovaRepeaterBlocks\Support\RenderEngine::renderRepeatersJson({$expression})); ?>";
        });
    }

    private function registerMorphmaps()
    {
        Relation::morphMap([
            'repeater.text_block' => TextBlock::class,
            'repeater.textarea_block' => TextareaBlock::class,
            'repeater.image_block' => ImageBlock::class,
            'repeater.custom_view_block' => CustomViewBlock::class,
            'repeater.markdown_block' => MarkdownBlock::class,
        ]);
    }
}
