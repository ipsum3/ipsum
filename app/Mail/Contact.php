<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('contact.mail')
            ->from(config('settings.contact_email'), config('settings.nom_site'))
            ->replyTo($this->contact->email, $this->contact->nom)
            ->to(config('settings.contact_email'), config('settings.nom_site'))
            ->subject('Contact site Internet '.config('settings.nom_site'));
    }
}
