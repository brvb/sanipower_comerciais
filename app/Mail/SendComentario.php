<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendComentario extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $propostas;
     protected $comentario;


    public function __construct($propostas,$comentario)
    {
        $this->propostas = $propostas;
        $this->comentario = $comentario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.comentario')
            ->subject('Sanipower, S.A. - Comentário de Proposta')
            ->with([
                'comentario' => $this->comentario,
                'propostas' => $this->propostas,
            ]);
    }
    
}
