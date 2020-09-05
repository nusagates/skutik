<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;
    private $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment= $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $comment = $this->comment;
        $name = $this->comment->user->name;
        $utm_tracking = "?utm_source=notification&utm_medium=email&utm_campaign=new_comment";
        return (new MailMessage)
            ->subject('Komentar Baru dari ' . $name)
            ->greeting('Hai, ' . $comment->post->user->name)
            ->line("Artikel berjudul '" . $comment->post->post_title . "' mendapat sebuah komentar dari $name. Silahkan klik tombol lihat di bawah untuk membacanya.")
            ->action('Lihat', route('post.show', $comment->post->slug . $utm_tracking))
            ->line("Pesan ini dibuat otomatis oleh sistem. Jangan membalasnya");
    }

    public function toDatabase($notifiable)
    {
        return [
            'data' => $this->comment->comment_content
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
