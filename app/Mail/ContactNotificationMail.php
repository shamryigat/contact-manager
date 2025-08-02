<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $action;
    public $oldData;

    /**
     * @param Contact $contact  The contact involved
     * @param string $action    Action: Added, Updated, or Deleted
     * @param array|null $oldData Old data (only for updates or deletes)
     */
    public function __construct(Contact $contact, string $action, $oldData = null)
    {
        $this->contact = $contact;
        $this->action = $action;
        $this->oldData = $oldData;
    }

    public function build()
    {
        return $this->subject("Contact {$this->action}")
                    ->markdown('emails.contact.notification');
    }
}
