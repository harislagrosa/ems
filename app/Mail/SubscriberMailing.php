<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class SubscriberMailing extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@example.com', 'Landville')
            ->subject($this->subject)
            ->markdown('mails.subscriber')
            ->with([
                'message' => $this->message,
            ]);
        // return $this->view('view.name');
    }
}
