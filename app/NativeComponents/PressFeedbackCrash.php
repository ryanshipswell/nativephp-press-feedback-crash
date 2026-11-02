<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Each button crashes the app on Android when a node that stays on screen gains or loses press
 * feedback between renders. Restart the app between scenarios.
 */
class PressFeedbackCrash extends NativeComponent
{
    public bool $gained = false;

    public bool $kept = true;

    public bool $bannerVisible = true;

    public function gainFeedback(): void
    {
        $this->gained = true;
    }

    public function loseFeedback(): void
    {
        $this->kept = false;
    }

    public function hideBanner(): void
    {
        $this->bannerVisible = false;
    }

    public function pressed(): void
    {
        //
    }

    public function render(): View
    {
        return view('native.press-feedback-crash');
    }
}
