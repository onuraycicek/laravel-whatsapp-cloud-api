<?php

namespace WCA\WCA\Package\Request\BusinessPhoneNumberRequest;

use WCA\WCA\Package\Request;

final class BusinessPhoneNumberRequest extends Request
{
    /**
     * @var string WhatsApp Number Id from messages will sent.
     */
    private string $business_id;

    public function __construct(string $access_token, string $business_id, ?int $timeout = null)
    {
        $this->business_id = $business_id;

        parent::__construct($access_token, $timeout);
    }

    /**
     * Returns the Business ID.
     *
     * @return string
     */
    public function businessId(): string
    {
        return $this->business_id;
    }

    /**
     * WhatsApp node path.
     *
     * @return string
     */
    public function nodePath(): string
    {
        return $this->business_id . '/phone_numbers';
    }
}
