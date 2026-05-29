<?php
A<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiStepForm extends Component
{
    /**
     * CORE CONTENT
     */
    public string $eventName;
    public string $formTitle;

    /**
     * NAVIGATION
     */
    public ?string $title;
    public ?string $previousStepRoute;

    /**
     * FLOW CONTROL
     */
    public bool $lastStep;
    public bool $end;

    /**
     * ✨ UI / UX ENHANCEMENTS
     */
    public ?string $subtitle;
    public ?string $icon;

    public int $currentStep;
    public int $totalSteps;

    public bool $showProgressBar;
    public bool $showStepIndicator;
    public bool $allowBackNavigation;
    public bool $compact;
    public bool $autoFocusFirstInput;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $eventName,
        string $formTitle,
        ?string $title = null,
        ?string $previousStepRoute = null,
        bool $lastStep = false,
        bool $end = false,

        // ✨ UI ENHANCEMENTS
        ?string $subtitle = null,
        ?string $icon = 'form',

        int $currentStep = 1,
        int $totalSteps = 1,

        bool $showProgressBar = true,
        bool $showStepIndicator = true,
        bool $allowBackNavigation = true,
        bool $compact = false,
        bool $autoFocusFirstInput = true
    ) {
        $this->eventName = $eventName;
        $this->formTitle = $formTitle;

        $this->title = $title;
        $this->previousStepRoute = $previousStepRoute;

        $this->lastStep = $lastStep;
        $this->end = $end;

        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->currentStep = $currentStep;
        $this->totalSteps = $totalSteps;

        $this->showProgressBar = $showProgressBar;
        $this->showStepIndicator = $showStepIndicator;
        $this->allowBackNavigation = $allowBackNavigation;
        $this->compact = $compact;
        $this->autoFocusFirstInput = $autoFocusFirstInput;
    }

    /**
     * Render view
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.multi-step-form');
    }
}
namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiStepForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $eventName,
        public string $formTitle,
        public ?string $title = null,
        public ?string $previousStepRoute = null,
        public bool $lastStep = false,
        public bool $end = false
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.multi-step-form');
    }
}
