<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Index extends Component
{
    /**
     * ROUTING
     */
    public string $route;
    public bool $index;
    public array $routeParams;

    /**
     * ✨ UI / UX ENHANCEMENTS
     */
    public ?string $title;
    public ?string $subtitle;
    public ?string $icon;

    public bool $showCreateButton;
    public bool $showSearch;
    public bool $showFilters;
    public bool $compact;
    public bool $useCards;
    public bool $stickyHeader;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $route = '',
        bool $index = false,
        string $title = '',
        array $routeParams = [],

        // ✨ UI ENHANCEMENTS
        ?string $subtitle = null,
        ?string $icon = 'list',

        bool $showCreateButton = true,
        bool $showSearch = true,
        bool $showFilters = true,
        bool $compact = false,
        bool $useCards = true,
        bool $stickyHeader = true
    ) {
        $this->route = $route;
        $this->index = $index;
        $this->routeParams = $routeParams;

        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->showCreateButton = $showCreateButton;
        $this->showSearch = $showSearch;
        $this->showFilters = $showFilters;
        $this->compact = $compact;
        $this->useCards = $useCards;
        $this->stickyHeader = $stickyHeader;
    }

    /**
     * Render view
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.index');
    }
}
