<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Visitas;

class SendRelatorio extends Mailable
{
    use Queueable, SerializesModels;

    protected array $pdfContents;
    public array $visita = [];
    public array $visit = [];
    public array $anexo = [];

    /**
     * Create a new message instance.
     *
     * @param array $pdfContents Array com conteúdos de PDFs
     * @param array $visita Dados da visita
     */
    public function __construct(array $pdfContents, $visita, $visit)
    {
        $this->pdfContents = $pdfContents;
        $this->visita = json_decode($visita, true);
        $this->visit = json_decode($visit, true);
        $visitModel = Visitas::where('id_visita_agendada', $this->visita['id'])->first();

        if ($visitModel && isset($visitModel->anexos)) {
            $this->anexo = json_decode($visitModel->anexos, true) ?? [];
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('mail.relatorio')
            ->subject('Relatório de Visita Nº' . $this->visita['id'] . ' Sanipower, S.A.')
            ->with(['visita' => $this->visita, 'visitComment' => $this->visit]);

        // Anexar PDFs enviados pelo construtor
        foreach ($this->pdfContents as $index => $pdf) {
            $pdfContent = $pdf['content'];
            $pdfType = $pdf['type']; // "Visita", "Encomenda", ou "Proposta"

            $filename = "{$pdfType}_{$index}.pdf";

            $email->attachData($pdfContent, $filename, [
                'mime' => 'application/pdf',
            ]);
        }

        // Anexar arquivos da propriedade `anexos` no banco de dados
        foreach ($this->anexo as $filePath) {
            // Obtém o caminho físico no servidor
            $fullPath = storage_path('app/public/' . $filePath);
        
            // Verifica se o arquivo existe antes de anexar
            if (file_exists($fullPath)) {
                $email->attach($fullPath);
            }
        }
        

        return $email;
    }
}
