<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


        public $questionTitle;
        public $commentAuthorName;
        public $commentLink;

        public function __construct($questionTitle, $commentAuthorName, $commentLink)
        {
            $this->questionTitle = $questionTitle;
            $this->commentAuthorName = $commentAuthorName;
            $this->commentLink = $commentLink;
        }

        public function build()
        {
            return $this->subject('New Comment on Your Question')
                ->view('comment_added_mail');
        }

}
