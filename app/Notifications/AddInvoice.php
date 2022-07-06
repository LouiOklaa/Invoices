<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddInvoice extends Notification
{
    use Queueable;
    private $InvoiceID;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($InvoiceID)
    {
        $this->InvoiceID = $InvoiceID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail' , 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'http://localhost:8000/InvoicesDetails/'.$this->InvoiceID;
        return (new MailMessage)
                    ->greeting('!مرحبا')
                    ->subject('اضافة فاتورة جديدة')
                    ->line('تمت اضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', $url)
                    ->salutation('شكرا لاستخدامك لؤي سوفت لادارة الفواتير');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [

            'id'=> $this->InvoiceID,
            'title'=>' تم اضافة فاتورة جديد بواسطة : ',
            'user'=> Auth::user()->name,

        ];
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
            //
        ];
    }
}
