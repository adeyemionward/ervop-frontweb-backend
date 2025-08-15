<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build(){
        return $this->from($address = 'infotest@sserves.com', $name = 'SphereServe')
        ->subject('Account Verification OTP')
        ->view('emails.email_otp')
        ->with([
            'otp'   =>  $this->otp,
        ]);
    }
}
