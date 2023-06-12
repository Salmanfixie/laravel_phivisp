<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PhishingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $phishing_link;
    public $name;
    public $phone_no;
    public $company;
    public $email_subject;
    public $phishing_company;

    /**
     * Create a new message instance.
     *
     * @param string $url
     * @return void
     */

    public function __construct($phishing_link, $name, $phone_no, $company, $email_subject, $phishing_company)
    {
        $this->phishing_link = $phishing_link;
        $this->name = $name;
        $this->phone_no = $phone_no;
        $this->company = $company;
        $this->email_subject = $email_subject;
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
            ->markdown('mail.phishing_email');
    }
}
