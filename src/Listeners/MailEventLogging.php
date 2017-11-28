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
        $subject       = $message->getSubject() ?? false;
        $date          = $message->getDate()->format('d.m.Y') . ' | ' . $message->getDate()->getTimezone()->getName();
        $from          = $message->getFrom() ?? [];
        $replyTo       = $message->getReplyTo() ?? [];
        $to            = $message->getTo() ?? [];
        $cc            = $message->getCc() ?? [];
        $bcc           = $message->getBcc() ?? [];
        $readReceiptTo = $message->getReadReceiptTo() ?? [];
        // $body          = $message->getBody() ?? false;

        $properties['attributes']['subject']          = $subject;
        $properties['attributes']['date']             = $date;
        $properties['attributes']['from']             = implode('| ', array_map('self::customImplode', $from,          array_keys($from)));
        $properties['attributes']['replyTo']          = implode('| ', array_map('self::customImplode', $replyTo,       array_keys($replyTo)));
        $properties['attributes']['to']               = implode('| ', array_map('self::customImplode', $to,            array_keys($to)));
        $properties['attributes']['cc']               = implode('| ', array_map('self::customImplode', $cc,            array_keys($cc)));
        $properties['attributes']['bcc']              = implode('| ', array_map('self::customImplode', $bcc,           array_keys($bcc)));
        $properties['attributes']['readReceiptTo']    = implode('| ', array_map('self::customImplode', $readReceiptTo, array_keys($readReceiptTo)));
        // $properties['attributes']['body']             = $body;

        return $properties;
    }

    /**
     * Convert array to string for array_map
     *
     * @param  string $key
     * @param  string $value
     * @return string $propertyString
     */
    private static function customImplode($value, $key)
    {
        if(is_array($value)) {
            return $key . ' []=> ' . implode('&' . $key .' []=> ', $value);
        } else {
            return $key . ' => ' . $value;
        }
    }
}
