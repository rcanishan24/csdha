<?php

namespace App\Events;

use App\Models\GpoaActivity;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GpoaActivityStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public GpoaActivity $activity;

    /**
     * Create a new event instance.
     */
    public function __construct(GpoaActivity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Secure broadcast channel
     * (you can later scope this per org / role)
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('gpoa-activities'),
        ];
    }

    /**
     * Frontend event name
     */
    public function broadcastAs(): string
    {
        return 'gpoa.activity.status.changed';
    }

    /**
     * Payload for real-time UI updates
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->activity->id,
            'title' => $this->activity->title ?? null,
            'description' => $this->activity->description ?? null,

            'old_status' => $this->activity->getOriginal('status'),
            'status' => $this->activity->status,

            'assigned_to' => $this->activity->assigned_to ?? null,
            'updated_at' => $this->activity->updated_at,
        ];
    }
}
