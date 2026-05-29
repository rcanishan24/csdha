<?php

namespace App\Events;

use App\Models\AccomReport;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccomReportStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public AccomReport $accomReport;

    /**
     * Create a new event instance.
     */
    public function __construct(AccomReport $accomReport)
    {
        $this->accomReport = $accomReport;
    }

    /**
     * Define broadcast channel (more secure + scalable)
     * Each report gets its own channel for real-time updates
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('accom-reports.' . $this->accomReport->id),
        ];
    }

    /**
     * Event name sent to frontend
     */
    public function broadcastAs(): string
    {
        return 'accom-report.status.changed';
    }

    /**
     * Data sent to frontend (THIS powers your UI updates)
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->accomReport->id,
            'status' => $this->accomReport->status,
            'title' => $this->accomReport->title ?? null,
            'updated_at' => $this->accomReport->updated_at,
        ];
    }
}
