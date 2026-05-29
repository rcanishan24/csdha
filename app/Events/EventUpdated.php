<?php

namespace App\Events;

use App\Models\Event as SystemEvent;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventUpdated implements ShouldBroadcast
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
     * Broadcast channel (central event stream)
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('events'),
        ];
    }

    /**
     * Frontend event name
     */
    public function broadcastAs(): string
    {
        return 'event.updated';
    }

    /**
     * Payload sent to UI (dashboard-ready)
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->event->id,
            'title' => $this->event->title ?? null,
            'description' => $this->event->description ?? null,

            'start_date' => $this->event->start_date ?? null,
            'end_date' => $this->event->end_date ?? null,

            'location' => $this->event->location ?? null,
            'status' => $this->event->status ?? null,

            'updated_at' => $this->event->updated_at,
        ];
    }
}
