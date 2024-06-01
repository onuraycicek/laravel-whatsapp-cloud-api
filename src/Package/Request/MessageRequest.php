<?php

namespace WCA\WCA\Package\Request;

use WCA\WCA\Package\Message\Message;
use WCA\WCA\Package\Request;

abstract class MessageRequest extends Request implements RequestWithBody
{
    /**
     * @var Message WhatsApp Message to be sent.
     */
    protected Message $message;

    /**
     * @var string WhatsApp Number Id from messages will sent.
     */
    private string $from_phone_number_id;

    public function __construct(Message $message, string $access_token, string $from_phone_number_id, ?int $timeout = null)
    {
        $this->message = $message;
        $this->from_phone_number_id = $from_phone_number_id;

        parent::__construct($access_token, $timeout);
    }

    /**
     * Return WhatsApp Number Id for this request.
     */
    public function fromPhoneNumberId(): string
    {
        return $this->from_phone_number_id;
    }

    /**
     * WhatsApp node path.
     */
    public function nodePath(): string
    {
        return $this->from_phone_number_id.'/messages';
    }
}
