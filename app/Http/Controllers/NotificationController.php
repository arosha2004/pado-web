<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('recipient_id', auth()->id())->latest()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        if ($notification->recipient_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);

        return back();
    }

    public function markAllRead()
    {
        Notification::where('recipient_id', auth()->id())->whereNull('read_at')->update(['read_at' => now()]);

        return back();
    }
}
