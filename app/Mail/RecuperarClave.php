<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarClave extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nombre, String $clave)
    {
        //
        $this->nombre = $nombre;
        $this->clave = $clave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('contacto@vitrinalaboral.cl')
             ->subject('Nueva Contraseña')
             ->view('mensajes.clave')
             ->with([
                'nombre' => $this->nombre,
                'clave' => $this->clave
             ]);
    }
}
