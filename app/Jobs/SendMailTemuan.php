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
    protected $type;
    public function __construct($user, $data, $detail, $type = null)
    {
        $this->user = $user;
        $this->data = $data;
        $this->detail = $detail;
        $this->type = $type;
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
        $type = $this->type;
        foreach ($user as $key => $item) {
           Mail::to($item->email)->send(new TemuanEmail($item, $data, $detail, $type));
        }
    }
}
