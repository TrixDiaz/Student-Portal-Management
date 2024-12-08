<?php

namespace App\Livewire\Notification;

use App\Models\User;
use App\Notifications\StudentNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $message;

    protected $rules = [
        'title' => 'required|min:3',
        'message' => 'required|min:10',
    ];

    public function sendNotification()
    {
        $this->validate();

        $students = User::role('student')->get();

        foreach ($students as $student) {
            $student->notify(new StudentNotification(
                $this->title,
                $this->message,
            ));
        }

        Notification::send($students, new StudentNotification(
            $this->title,
            $this->message,
        ));
        toastr()->success('Notification sent successfully!');
        redirect()->back()->with('message', 'Notification sent successfully!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.notification.create');
    }
}
