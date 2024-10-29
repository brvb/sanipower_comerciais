<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRelatorio extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $pdfContent;
     public array $visita = [];

     public function __construct($pdfContent, $visita)
     {
        dd(json_decode($visita));
        $this->pdfContent = $pdfContent;
        $this->visita = json_decode($visita, true);
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.relatorio')
                ->subject('Sanipower, S.A.')
                ->attachData($this->pdfContent, 'RelatorioVisita.pdf', [
                            'mime' => 'application/pdf',
                            'visita' => $this->visita,
                        ]);
    }
}
