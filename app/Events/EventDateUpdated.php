<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventDateUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Event $event;

    /**
     * Create a new event instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Secure channel for event updates
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('events'),
        ];
    }

    /**
     * Event name for frontend listener
     */
    public function broadcastAs(): string
    {
        return 'event.date.updated';
    }

    /**
     * Data sent to frontend (UI-ready payload)
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->event->id,
            'title' => $this->event->title ?? null,
            'old_date' => $this->event->getOriginal('date'),
            'new_date' => $this->event->date,
            'location' => $this->event->location ?? null,
            'updated_at' => $this->event->updated_at,
        ];
    }
}
