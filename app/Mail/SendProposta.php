<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendProposta extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $propName;
     protected $pdfContent;

    public function __construct($pdfContent, $propName)
    {
        $this->pdfContent = $pdfContent;
        $this->propName = $propName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.proposta')
                ->subject($this->propName.' Sanipower, S.A.')
                ->attachData($this->pdfContent, 'Proposta.pdf', [
                            'mime' => 'application/pdf',
                        ]);
    }
}
