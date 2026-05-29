<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextOnly extends Component
{
    /**
     * ✨ TYPOGRAPHY CONTENT
     */
    public ?string $title;
    public ?string $subtitle;
    public ?string $description;

    /**
     * ✨ UI / UX OPTIONS
     */
    public string $align;
    public bool $centered;
    public bool $compact;
    public bool $muted;
    public bool $showDivider;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $title = null,
        ?string $subtitle = null,
        ?string $description = null,

        string $align = 'left',
        bool $centered = false,
        bool $compact = false,
        bool $muted = false,
        bool $showDivider = false
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->description = $description;

        $this->align = $align;
        $this->centered = $centered;
        $this->compact = $compact;
        $this->muted = $muted;
        $this->showDivider = $showDivider;
    }

    /**
     * Render view
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.text-only');
    }
}
