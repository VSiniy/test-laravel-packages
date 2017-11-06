<?php

namespace Ebola\Logging\Listeners;

class MailEventLogging
{
    /**
     * Handle message sending events.
     */
    public function onMessageSending($event) 
    {
        activity('message-sending')->withProperties($this->getProperties($event->message))
                                   ->log('Message is sending');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Mail\Events\MessageSending',
            'Ebola\Logging\Listeners\MailEventLogging@onMessageSending'
        );
    }

    /**
     * Get properties for log.
     *
     * @param  \Swift\Mime\SimpleMessage  $message
     * @return array $properties
     */
    private function getProperties($message)
    {
        $properties['attributes']['subject']          = $message->getSubject() ?? false;
        $properties['attributes']['date']['date']     = $message->getDate()->format('d.m.Y') ?? false;
        $properties['attributes']['date']['timezone'] = $message->getDate()->getTimezone()->getName() ?? false;
        $properties['attributes']['from']             = $message->getFrom() ?? false;
        $properties['attributes']['replyTo']          = $message->getReplyTo() ?? false;
        $properties['attributes']['to']               = $message->getTo() ?? false;
        $properties['attributes']['cc']               = $message->getCc() ?? false;
        $properties['attributes']['bcc']              = $message->getBcc() ?? false;
        $properties['attributes']['readReceiptTo']    = $message->getReadReceiptTo() ?? false;
        $properties['attributes']['body']             = $message->getBody() ?? false;

        return $properties;
    }
}
