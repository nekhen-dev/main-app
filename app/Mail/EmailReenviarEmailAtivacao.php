<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailReenviarEmailAtivacao extends Mailable
{
    use Queueable, SerializesModels;
    public $dados;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_dados)
    {
        $this->dados = $_dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->view('emails.reenviarEmailAtivacao')
                ->from($this->dados->remetente_email ,$this->dados->remetente)
                ->to($this->dados->destinatario_email,$this->dados->destinatario)
                ->subject('Ative seu cadastro com a Nekhen (novo link)')
        ;
    }
    public function enviar(){
        Mail::send($this);
    }
}
