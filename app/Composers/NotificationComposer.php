<?php

namespace App\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view)
    {
        $notifications = Auth::user()->unreadNotifications;

        $view->with('notifications', $notifications);
    }
}
