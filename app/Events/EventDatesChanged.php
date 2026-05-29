<?php

namespace App\Events;

use App\Models\Event as SystemEvent;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventDatesChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SystemEvent $event;

    /**
     * Create a new event instance.
     */
    public function __construct(SystemEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Broadcast channel (secure + scalable)
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('events'),
        ];
    }

    /**
     * Event name for frontend listeners
     */
    public function broadcastAs(): string
    {
        return 'event.dates.changed';
    }

    /**
     * Payload for UI updates
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->event->id,
            'title' => $this->event->title ?? null,

            // full date lifecycle (important for rescheduling UI)
            'start_date' => $this->event->start_date ?? null,
            'end_date' => $this->event->end_date ?? null,

            // old values (for UI comparison / animation)
            'old_start_date' => $this->event->getOriginal('start_date'),
            'old_end_date' => $this->event->getOriginal('end_date'),

            'location' => $this->event->location ?? null,
            'updated_at' => $this->event->updated_at,
        ];
    }
}
