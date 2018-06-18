<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PagoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $datos_pago;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $datos_pago)
    {
        $this->user = $user;
        $this->datos_pago = $datos_pago;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.pago')
                    ->subject('Ticket || PalomitasTime :D');
    }
}
