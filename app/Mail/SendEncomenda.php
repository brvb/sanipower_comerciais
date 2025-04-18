<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEncomenda extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $pdfContent;
     public array $encomenda = [];

     public function __construct($pdfContent, $encomenda)
     {
        // dd($encomenda);
        $this->pdfContent = $pdfContent;
        $this->encomenda = $encomenda; // Corrigido: atribuir diretamente à propriedade
        // dd($this->encomenda);
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.encomenda')
                ->subject($this->encomenda['order'].' Sanipower, S.A.')
                ->attachData($this->pdfContent, 'Encomenda.pdf', [
                            'mime' => 'application/pdf',
                            'encomenda' => $this->encomenda,
                        ]);
    }
}
