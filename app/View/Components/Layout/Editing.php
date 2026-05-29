<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Editing extends Component
{
    /**
     * NAVIGATION
     */
    public string $backRoute;
    public string $backName;
    public array $routeParams;

    /**
     * ✨ UI / UX ENHANCEMENTS
     */
    public ?string $title;
    public ?string $subtitle;
    public ?string $icon;

    public bool $showBackButton;
    public bool $showSaveHint;
    public bool $compact;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $backRoute,
        string $backName,
        array $routeParams = [],

        // ✨ UI ENHANCEMENTS
        ?string $title = null,
        ?string $subtitle = null,
        ?string $icon = 'edit',

        bool $showBackButton = true,
        bool $showSaveHint = true,
        bool $compact = false
    ) {
        $this->backRoute = $backRoute;
        $this->backName = $backName;
        $this->routeParams = $routeParams;

        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->showBackButton = $showBackButton;
        $this->showSaveHint = $showSaveHint;
        $this->compact = $compact;
    }

    /**
     * Render view
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.editing');
    }
}
