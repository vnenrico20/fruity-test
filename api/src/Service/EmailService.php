<?php


namespace App\Service;

use Swift_Mailer as SwiftMailer;

class EmailService
{
    public function __construct(
        public SwiftMailer $mailer
    )
    {
    }

    public function sendEmail($from, $to, $subject, $body): void
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }
}
