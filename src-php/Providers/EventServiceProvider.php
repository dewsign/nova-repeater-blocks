<?php

namespace Dewsign\NovaRepeaterBlocks\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Dewsign\NovaRepeaterBlocks\Events\RepeaterSaved;
use Dewsign\NovaRepeaterBlocks\Listeners\UpdateRepeaterRelations;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RepeaterSaved::class => [
            UpdateRepeaterRelations::class,
        ],
    ];

        /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
