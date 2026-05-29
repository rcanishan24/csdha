<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
{
    /**
     * BACK NAVIGATION
     */
    public string $backRoute;
    public string $backName;
    public array $routeParams;

    /**
     * UI ENHANCEMENTS (NEW)
     */
    public ?string $title;
    public ?string $subtitle;
    public ?string $icon;
    public bool $showBackButton;
    public bool $compact;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $backRoute,
        string $backName,

        array $routeParams = [],

        // ✨ NEW UI FEATURES
        ?string $title = null,
        ?string $subtitle = null,
        ?string $icon = null,

        bool $showBackButton = true,
        bool $compact = false
    ) {
        $this->backRoute = $backRoute;
        $this->backName = $backName;
        $this->routeParams = $routeParams;

        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->showBackButton = $showBackButton;
        $this->compact = $compact;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.content');
    }
}
