<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Anexos;
use App\Interfaces\ClientesInterface;

class SendOcorrencia extends Mailable
{
    use Queueable, SerializesModels;

    protected array $pdfContents;
    public string $ocorrencia;
    public array $ocorrenciaArray = [];
    public array $anexo = [];
    private ?object $clientesRepository = NULL;

    /**
     * Create a new message instance.
     *
     * @param array $pdfContents Array com conteúdos de PDFs
     * @param array $visita Dados da visita
     */
    public function __construct($idOcorrencia)
    {          
        $anexo = Anexos::where('idOcorrencia', $idOcorrencia)->first();
        $this->ocorrencia = $idOcorrencia;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/occurrence?occurrence_id='.$idOcorrencia,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $ocorrencia = $response_decoded->occurrences;

        $this->ocorrenciaArray = $ocorrencia;

        if ($anexo && isset($anexo->anexo)) {
            $this->anexo = json_decode($anexo->anexo, true) ?? [];
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('mail.ocorrencia', ['ocorrenciaArray' => $this->ocorrenciaArray[0]])
            ->subject($this->ocorrenciaArray[0]->document.' Nº' . $this->ocorrenciaArray[0]->document_number . ', Cliente - '.$this->ocorrenciaArray[0]->customer_name .'. Sanipower, S.A.');

        foreach ($this->anexo as $filePath) {

            $fullPath = storage_path('app/public/' . $filePath);
        

            if (file_exists($fullPath)) {
                $email->attach($fullPath);
            }
        }
        

        return $email;
    }
}
