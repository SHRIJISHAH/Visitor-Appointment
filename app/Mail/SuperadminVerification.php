<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuperadminVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationLink;
    public $superadmin;
    public $otp;

    public function __construct($verificationLink, $superadmin, $otp)
    {
        $this->verificationLink = $verificationLink;
        $this->superadmin = $superadmin;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->view('emails.superadmin-verification');
    }
}
