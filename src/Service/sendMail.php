<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class sendMail {

    protected MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;

    }

public function sendMail( $email, $object, $contenu){
    

    $sendM = (new Email())
        ->from($email)
        ->to('you@example.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject($object)
        ->text($contenu)
        ->html($contenu);

        return $this->mailer ->send($sendM) ;
}

}

?>