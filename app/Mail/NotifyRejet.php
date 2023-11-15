<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyRejet extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details;
    public function __construct($details)
    {
        //
        $this->details = $details;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $det=$this->details;
        return $this->view('mail.notify_rejet',compact('det'))->subject("Notification de Rejet de Votre Demande sur la plateforme e-création");
    }
}
