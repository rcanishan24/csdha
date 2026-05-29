<?php

namespace App\Events;

use App\Models\Gpoa;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GpoaCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Gpoa $gpoa;

    /**
     * Create a new event instance.
     */
    public function __construct(Gpoa $gpoa)
    {
        $this->gpoa = $gpoa;
    }

    /**
     * Broadcast channel for system-wide GPOA updates
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('gpoa'),
        ];
    }

    /**
     * Frontend event name
     */
    public function broadcastAs(): string
    {
        return 'gpoa.created';
    }

    /**
     * UI-ready payload for instant dashboard updates
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->gpoa->id,
            'title' => $this->gpoa->title ?? null,
            'description' => $this->gpoa->description ?? null,

            'status' => $this->gpoa->status ?? 'draft',
            'created_at' => $this->gpoa->created_at,

            // UI hint for frontend animations
            'is_new' => true,
        ];
    }
}
