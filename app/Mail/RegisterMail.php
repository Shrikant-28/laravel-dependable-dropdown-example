<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $extraSettings;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($extraSettings)
    {
        //
        $this->extraSettings = $extraSettings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from SAR')
                    ->view('emails.registration-success');
       // return $this->view('view.name');
    }
}
