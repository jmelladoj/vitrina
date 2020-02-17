<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsuarioNuevo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario)
    {
        //
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('contacto@vitrinalaboral.cl')
             ->subject('Bienvenido a Vitrina Laboral')
             ->view('mensajes.nuevo')
             ->with([
                'usuario' => $this->usuario
             ]);
    }
}
