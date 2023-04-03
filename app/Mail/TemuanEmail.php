<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TemuanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($user)
    {
        $this->data = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        return $this->subject('Pemberitahuan Temuan Pengadilan Agama')
            ->view('temuan.email', compact('data'));
    }
}
