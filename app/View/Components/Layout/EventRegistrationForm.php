<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Event;

class EventRegistrationForm extends Component
{
    /**
     * CORE DATA
     */
    public Event $event;
    public int $step;
    public int $completeSteps;
    public array $routes;

    /**
     * ✨ UI / UX ENHANCEMENTS
     */
    public ?string $title;
    public ?string $subtitle;
    public ?string $icon;

    public bool $showProgressBar;
    public bool $showStepIndicator;
    public bool $allowStepNavigation;
    public bool $showWelcomeScreen;
    public bool $compact;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Event $event,
        int $step,
        int $completeSteps,
        array $routes,

        // ✨ UI ENHANCEMENTS
        ?string $title = null,
        ?string $subtitle = null,
        ?string $icon = 'user-plus',

        bool $showProgressBar = true,
        bool $showStepIndicator = true,
        bool $allowStepNavigation = false,
        bool $showWelcomeScreen = true,
        bool $compact = false
    ) {
        $this->event = $event;
        $this->step = $step;
        $this->completeSteps = $completeSteps;
        $this->routes = $routes;

        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->showProgressBar = $showProgressBar;
        $this->showStepIndicator = $showStepIndicator;
        $this->allowStepNavigation = $allowStepNavigation;
        $this->showWelcomeScreen = $showWelcomeScreen;
        $this->compact = $compact;
    }

    /**
     * Render view
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.event-registration-form');
    }
}
