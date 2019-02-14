<?php

declare(strict_types=1);

namespace LinioPay\Idle\Queue;

class Message
{
    /** @var string */
    protected $messageIdentifier;

    /** @var string */
    protected $queueIdentifier;

    /** @var string */
    protected $body;

    /** @var array */
    protected $attributes;

    /** @var array */
    protected $metadata;

    public function __construct(string $queueIdentifier, string $body, array $attributes = [], string $messageIdentifier = '', array $metadata = [])
    {
        $this->queueIdentifier = $queueIdentifier;
        $this->body = $body;
        $this->attributes = $attributes;
        $this->messageIdentifier = $messageIdentifier;
        $this->metadata = $metadata;
    }

    public function getMessageIdentifier() : string
    {
        return $this->messageIdentifier;
    }

    public function setMessageIdentifier(string $messageIdentifier) : void
    {
        $this->messageIdentifier = $messageIdentifier;
    }

    public function getQueueIdentifier() : string
    {
        return $this->queueIdentifier;
    }

    public function getBody() : string
    {
        return $this->body;
    }

    public function getAttributes() : array
    {
        return $this->attributes;
    }

    public function getTemporaryMetadata() : array
    {
        return $this->metadata;
    }

    public function toArray()
    {
        return [
            'messageIdentifier' => $this->getMessageIdentifier(),
            'queueIdentifier' => $this->getQueueIdentifier(),
            'body' => $this->getBody(),
            'attributes' => $this->getAttributes(),
            'metadata' => $this->getTemporaryMetadata(),
        ];
    }
}
