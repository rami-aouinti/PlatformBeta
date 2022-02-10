<?php

namespace App\Message;

class EmailNotification
{
    /** @var string */
    private string $recipient;

    /** @var string */
    private string $subject;

    /** @var string */
    private string $content;

    /**
     * EmailNotification constructor.
     * @param string $recipient
     * @param string $subject
     * @param string $content
     */
    public function __construct(string $recipient, string $subject, string $content)
    {
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
