<?php

namespace App\Jobs;

use App\Mail\TemuanEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMailTemuan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $data;
    protected $detail;
    public function __construct($user, $data, $detail)
    {
        $this->user = $user;
        $this->data = $data;
        $this->detail = $detail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $data = $this->data;
        $detail = $this->detail;
        foreach ($user as $key => $item) {
           Mail::from('Aplikasi Hawasbid Pengadilan Agama Cirebon')->to($item->email)->send(new TemuanEmail($item, $data, $detail));
        }
    }
}
