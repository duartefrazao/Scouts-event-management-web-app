<?php

namespace App\Notifications;

use App\User;
use App\Group;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GroupOrganizerInvitation extends Notification
{
    use Queueable;

    public $host;
    public $user;
    public $group;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $host,User $user,Group $group )
    {
        $this->user = $user;
        $this->group = $group;
        $this->host = $host;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'host' => array($this->host->id, $this->host->name),
            'user' => array($this->user->id, $this->user->name),
            'group' => array($this->group->id, $this->group->name),
            'url' => '/groups/' . $this->group->id
        ];
    }
}
