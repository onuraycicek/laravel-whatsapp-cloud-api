<?php

namespace WCA\WCA\Package\Request\BusinessTemplateRequest;

use WCA\WCA\Package\Request;

final class BusinessTemplateRequest extends Request
{
    /**
     * @var string The page number.
     */
    private string $after = '';

    
    /**
     * @var string WhatsApp Number Id from messages will sent.
     */
    private string $business_id;

    public function __construct(string $access_token, string $business_id, string|null $after, ?int $timeout = null)
    {
        $this->business_id = $business_id;
        if ($after) {
            $this->after = $after;
        }

        parent::__construct($access_token, $timeout);
    }

    /**
     * Returns the Business ID.
     */
    public function businessId(): string
    {
        return $this->business_id;
    }

    /**
     * WhatsApp node path.
     */
    public function nodePath(): string
    {
        return $this->business_id.'/message_templates' . ($this->after ? '?after='.$this->after : '');
    }
}
