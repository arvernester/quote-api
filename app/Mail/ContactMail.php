<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Request object.
     *
     * @var Request
     */
    private $request;

    /**
     * Create a new message instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.contact.post')
            ->subject(__('Message from :sender', ['sender' => $this->request->name]))
            ->from($this->request->email, $this->request->name)
            ->with('request', $this->request);
    }
}
