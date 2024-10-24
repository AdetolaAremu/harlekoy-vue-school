<?php

namespace App\Listeners;

use App\Events\RecordUpdateEvent;
use App\Models\RecordUpdateTracker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordUpdateEventListener
{
    /**
     * Handle the event.
     */
    public function handle(RecordUpdateEvent $event): void
    {
        // so, what if a user has updated few minutes ago and make an adjustment again, we only need to track it once
        if (RecordUpdateTracker::where('user_id', $event->userId)->where('update_batched', false)->exists()) return;

        RecordUpdateTracker::create([
            'user_id' => $event->userId
        ]);
    }
}
