<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $message;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$message,$title)
    {
        $this->name = $name;
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->markdown('emails.notification');
    }
}
