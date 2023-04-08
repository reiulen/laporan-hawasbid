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

    public function __construct($user, $data, $detail, $type = null)
    {
        $this->user = $user;
        $this->data = $data;
        $this->detail = $detail;
        $this->type = $type;
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
        $type = $this->type;
        $subject = 'Pemberitahuan Temuan yang perlu ditindak lanjuti di Aplikasi Hawasbid Pengadilan Agama Cirebon';
        $cetak = "Lembar Temuan Pengadilan Agama Cirebon $data->penanggung_jawab_tindak_lanjut ";
        $body = 'Pesan ini dari Aplikasi Hawasbid Pengadilan Agama Cirebon. Terdapat temuan yang harus segera ditindak lanjuti. Terima Kasih';
        if($type) {
            $subject = "Pemberitahuan Temuan yang telah ditindak lanjuti di Aplikasi Hawasbid Pengadilan Agama Cirebon oleh $data->penanggung_jawab_tindak_lanjut";
            $cetak = "Lembar Temuan yang telah ditindak lanjuti Pengadilan Agama Cirebon $data->penanggung_jawab_tindak_lanjut ";
            $body = "Pesan ini dari Aplikasi Hawasbid Pengadilan Agama Cirebon. Terdapat temuan yang sudah ditindak lanjuti. Terima Kasih";
        }

        $pdf = PDF::loadview('temuan.exportPdf', compact('data', 'detail'))
                    ->setPaper('A4', 'portrait');
        return $this->subject($subject)
            ->attachData($pdf->output(), $cetak.'.pdf', [
                'mime' => 'application/pdf',
            ])
            ->view('temuan.email', compact('user', 'subject', 'body'));
    }
}
