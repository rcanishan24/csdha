<?php

namespace App\Events;

use App\Models\Gpoa;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GpoaUpdated implements ShouldBroadcast
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
     * Central GPOA broadcast channel
     * (single source of truth for frontend)
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
        return 'gpoa.updated';
    }

    /**
     * UI-ready payload (drives dashboard updates)
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->gpoa->id,
            'title' => $this->gpoa->title ?? null,
            'description' => $this->gpoa->description ?? null,

            'status' => $this->gpoa->status ?? null,

            'start_date' => $this->gpoa->start_date ?? null,
            'end_date' => $this->gpoa->end_date ?? null,

            'updated_at' => $this->gpoa->updated_at,
        ];
    }
}
