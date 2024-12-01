<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationMenu extends Component
{
    public $notifications;
    public $unreadNotificationsCount;

    public function markAllAsRead()
    {
        Auth::user()->notifications->markAsRead();
        $this->dispatch('notification-drawer-close');
        return redirect()->back();
    }

    public function clearAllNotifications()
    {
        Auth::user()->notifications()->delete();
        $this->dispatch('notification-drawer-close');
        return redirect()->back();
    }

    public function readNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $url = $notification->data['url'];
        $notification->markAsRead();
        $this->dispatch('notification-drawer-close');
        return redirect($url);
    }

    public function deleteNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->back();
    }

    public function mount()
    {
        $this->notifications = Auth::user()->notifications;
        $this->unreadNotificationsCount = $this->notifications->whereNull('read_at')->count();
    }

    public function render()
    {
        return view('livewire.layout.navigation-menu');
    }
}
