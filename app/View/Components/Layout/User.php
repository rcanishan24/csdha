<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class User extends Component
{
    /**
     * ROUTING
     */
    public ?string $route;
    public array $routeParams;
    public ?string $backRoute;

    /**
     * PAGE MODES
     */
    public bool $index;
    public bool $contentView;
    public bool $form;

    /**
     * ✨ UI / UX ENHANCEMENTS
     */
    public ?string $title;
    public ?string $subtitle;
    public ?string $icon;

    public bool $hasToolbar;
    public bool $showBackButton;
    public bool $showBreadcrumbs;
    public bool $compact;
    public string $style;

    /**
     * USER PAGE CONTEXT
     */
    public ?string $userRole;
    public bool $isAdminView;
    public bool $isProfileView;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $route = null,
        bool $index = false,
        bool $contentView = false,
        bool $form = false,
        ?string $title = null,
        array $routeParams = [],
        ?string $backRoute = null,
        bool $hasToolbar = false,
        ?string $style = null,

        // ✨ UI ENHANCEMENTS
        ?string $subtitle = null,
        ?string $icon = 'user',

        bool $showBackButton = true,
        bool $showBreadcrumbs = true,
        bool $compact = false,

        // 🧠 USER CONTEXT (NEW)
        ?string $userRole = null,
        bool $isAdminView = false,
        bool $isProfileView = false
    ) {
        $this->route = $route;
        $this->index = $index;
        $this->contentView = $contentView;
        $this->form = $form;
        $this->title = $title;
        $this->routeParams = $routeParams;
        $this->backRoute = $backRoute;
        $this->hasToolbar = $hasToolbar;
        $this->style = $style ?? 'default';

        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->showBackButton = $showBackButton;
        $this->showBreadcrumbs = $showBreadcrumbs;
        $this->compact = $compact;

        $this->userRole = $userRole;
        $this->isAdminView = $isAdminView;
        $this->isProfileView = $isProfileView;
    }

    /**
     * Render view
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.user');
    }
}
