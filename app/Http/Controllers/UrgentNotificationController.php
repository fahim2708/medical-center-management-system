<?php

namespace App\Http\Controllers;

use App\Models\UrgentNotification;
use Illuminate\Http\Request;

class UrgentNotificationController extends Controller
{
    public function index()
    {
        $notifications = UrgentNotification::orderBy('id', 'desc')->paginate(20);

        // Mark all unread notifications as read
        UrgentNotification::where('is_read', false)
            ->update(['is_read' => true]);

            
        return view('urgentNotification.index', compact('notifications'));
    }

    public function markAsRead(UrgentNotification $notification)
    {
        $notification->update(['is_read' => true]);
        return redirect()->back();
    }
}
