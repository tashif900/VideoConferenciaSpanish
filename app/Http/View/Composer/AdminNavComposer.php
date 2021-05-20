<?php
namespace App\Http\View\Composer;

use App\Notification;
use Illuminate\Contracts\View\View;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationResourceCollection;

class AdminNavComposer 
{
    public function compose(View $view)
    {
        $notifications = Notification::take(5)->whereNull('read_at')->orderBy('created_at', 'desc')->get();

        $notifications = new NotificationResourceCollection($notifications);

        $view->with('notifications', $notifications);
    }
}
