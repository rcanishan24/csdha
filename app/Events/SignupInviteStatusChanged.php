<?php

namespace App\Events;

use App\Models\SignupInvitation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignupInviteStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SignupInvitation $invite;

    /**
     * Create a new event instance.
     */
    public function __construct(SignupInvitation $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Secure channel for invitation updates
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('signup-invitations'),
        ];
    }

    /**
     * Frontend event name
     */
    public function broadcastAs(): string
    {
        return 'signup.invite.status.changed';
    }

    /**
     * UI-ready payload
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->invite->id,
            'email' => $this->invite->email ?? null,

            'old_status' => $this->invite->getOriginal('status'),
            'status' => $this->invite->status,

            'role' => $this->invite->role ?? null,
            'updated_at' => $this->invite->updated_at,
        ];
    }
}
