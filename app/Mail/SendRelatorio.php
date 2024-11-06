<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRelatorio extends Mailable
{
    use Queueable, SerializesModels;

    protected array $pdfContents;  // Array de conteúdos de PDF
    public array $visita = [];

    /**
     * Create a new message instance.
     *
     * @param array $pdfContents Array com conteúdos de PDFs
     * @param array $visita Dados da visita
     */
    public function __construct(array $pdfContents, $visita)
    {
        $this->pdfContents = $pdfContents;
        $this->visita = json_decode($visita, true);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('mail.relatorio')
                      ->subject(' Relatório de Visita Nº'.$this->visita['id'].' Sanipower, S.A.')
                      ->with(['visita' => $this->visita]); // Passa os dados da visita para a view

        // Itera sobre cada PDF e anexa com um nome único
        foreach ($this->pdfContents as $index => $pdf) {
            $pdfContent = $pdf['content'];
            $pdfType = $pdf['type']; // "Visita", "Encomenda", ou "Proposta"
            
            // Nomeia o arquivo com base no tipo
            $filename = "{$pdfType}_{$index}.pdf";
            
            $email->attachData($pdfContent, $filename, [
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
