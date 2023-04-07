<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class TemuanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($user, $data, $detail)
    {
        $this->user = $user;
        $this->data = $data;
        $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $data = $this->data;
        $detail = $this->detail;
        $cetak = "Lembar Temuan Hakim Pengawas Bidang Pengadilan Agama Cirebon $data->penanggung_jawab_tindak_lanjut ";

        $pdf = PDF::loadview('temuan.exportPdf', compact('data', 'detail'))
                    ->setPaper('A4', 'portrait');
        return $this->subject('Pemberitahuan Temuan yang perlu ditindaklanjuti di Aplikasi Hawasbid Pengadilan Agama Cirebon')
            ->attachData($pdf->output(), $cetak.'.pdf', [
                'mime' => 'application/pdf',
            ])
            ->view('temuan.email', compact('user'));
    }
}
