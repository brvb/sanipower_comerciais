<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAprovacao extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $pdfContent;
     public array $proposta = [];

    public function __construct($pdfContent, $proposta)
    {
        // dd($proposta->budgets[0]);
        $this->pdfContent = $pdfContent;
        $this->proposta = (array) $proposta->budgets[0];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.aprovacao')
                ->subject('Sanipower, S.A.')
                ->attachData($this->pdfContent, 'Proposta.pdf', [
                            'mime' => 'application/pdf',
                            'proposta' => $this->proposta,
                        ]);
    }
}
