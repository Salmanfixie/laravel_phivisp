<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EducateEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback_link;
    public $name;
    public $email_subject;
    public $phishing_email_subject;
    public $phishing_company;

    /**
     * Create a new message instance.
     *
     * @param string $url
     * @return void
     */

    public function __construct($feedback_link, $name, $email_subject, $phishing_email_subject, $phishing_company)
    {
        $this->feedback_link = $feedback_link;
        $this->name = $name;
        $this->email_subject = $email_subject;
        $this->phishing_email_subject = $phishing_email_subject;
        $this->phishing_company = $phishing_company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->email_subject)
            ->markdown('mail.educate_email');
    }
}
