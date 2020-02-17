<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Caducidad extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nombre)
    {
        //
        $this->nombre = $nombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('contacto@vitrinalaboral.cl')
             ->subject('Publicaciones')
             ->view('mensajes.caducidad')
             ->with([
                'nombre' => $this->nombre
             ]);
    }
}
