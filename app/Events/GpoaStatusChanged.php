<?php

namespace App\Events;

use App\Models\Gpoa;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GpoaStatusChanged implements ShouldBroadcast
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
     * Broadcast channel for all GPOA status updates
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
        return 'gpoa.status.changed';
    }

    /**
     * UI-ready payload
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->gpoa->id,
            'title' => $this->gpoa->title ?? null,

            'old_status' => $this->gpoa->getOriginal('status'),
            'status' => $this->gpoa->status,

            'updated_at' => $this->gpoa->updated_at,
        ];
    }
}
