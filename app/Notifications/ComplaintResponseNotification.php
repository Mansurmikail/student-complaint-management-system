<?php

namespace App\Notifications;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintResponseNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Complaint $complaint
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update on Your Submitted Complaint')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('An administrator has responded to your complaint.')
            ->line('Complaint Subject: ' . $this->complaint->subject)
            ->line('Administrator Response:')
            ->line($this->complaint->admin_response)
            ->line('Response Date: ' . $this->complaint->responded_at?->format('d M Y, h:i A'))
            ->action(
                'View Your Complaint',
                route('complaints.show', $this->complaint->id)
            )
            ->line('Thank you for using the Student Complaint Management System.');
    }
}
