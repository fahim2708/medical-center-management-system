<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('id', 'desc')->paginate(20);

        // Mark all unread notifications as read
        Notification::where('is_read', false)
            ->update(['is_read' => true]);

            
        return view('notification.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return redirect()->back();
    }
}
