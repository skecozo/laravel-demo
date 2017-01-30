<?php

namespace App\Notifications;

use App\Channels\SendcloudChannel;
use App\Comment;
use App\Services\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class ReceivedComment extends Notification
{
    use Queueable;

    protected $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendcloudChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toSendcloud($notifiable)
    {
        (new UserMailer())->ReceivedNotifyEmail($notifiable->email);
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
            'id' => $this->comment->id,
            'type'=>'comment',
            'content' => $this->comment->content,
            'user_id'=>$this->comment->user_id,
            'user_name'=>$this->comment->user->name,
            'article_id'=>$this->comment->commentable->id,
            'article_title'=>$this->comment->commentable->title,
        ];

    }
}
