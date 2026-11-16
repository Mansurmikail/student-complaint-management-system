<?php

namespace App\Notifications;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Complaint $complaint,
        public string $previousStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Complaint Status Has Been Updated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The status of your submitted complaint has been updated.')
            ->line('Complaint Subject: ' . $this->complaint->subject)
            ->line('Previous Status: ' . ucfirst(str_replace('_', ' ', $this->previousStatus)))
            ->line('New Status: ' . ucfirst(str_replace('_', ' ', $this->complaint->status)))
            ->action(
                'View Your Complaint',
                route('complaints.show', $this->complaint->id)
            )
            ->line('Thank you for using the Student Complaint Management System.');
    }
}
