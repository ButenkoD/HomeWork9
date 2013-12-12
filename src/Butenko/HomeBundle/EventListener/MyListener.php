<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 12/12/13
 * Time: 1:41 PM
 */

namespace Butenko\HomeBundle\EventListener;

use Butenko\HomeBundle\EventListener\PostAddedEvent;


class MyListener
{
    protected $mailer;

    public function onPostAdded(PostAddedEvent $event)
    {
        $this->sendMail($event);
    }

    public function sendMail(PostAddedEvent $event)
    {
        $post = $event->getPost();

        $transport = \Swift_MailTransport::newInstance();
        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance()
            ->setSubject('Добавлена запись')
            ->setFrom('nobody@example.com')
            ->setTo($post->getEmail())
            ->setBody('Вами была добаленна запись №'.$post->getId().'в гостевую книгу');

        $mailer->send($message);
    }

} 