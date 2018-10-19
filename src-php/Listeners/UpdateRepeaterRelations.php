<?php

namespace Dewsign\NovaRepeaterBlocks\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Log;

class UpdateRepeaterRelations
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (!$event->model->repeater) {
            return;
        }

        $event->model->repeater->repeatable->save();
    }
}
