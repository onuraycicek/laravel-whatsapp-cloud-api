<?php

namespace WCA\WCA;

class WCAApp
{
    /**
     * @const string Facebook Phone Number ID.
     */
    protected string $from_phone_number_id;

    /**
     * @const string Facebook Whatsapp Access Token.
     */
    protected string $access_token;

    /**
     * @const string Whatsapp Business ID.
     */
    protected string $business_id;

    /**
     * Sends a Whatsapp text message.
     *
     * @param string The Facebook Phone Number ID.
     * @param string The Facebook Whatsapp Access Token.
     * @param string The Whatsapp Business ID.
     */
    public function __construct(?string $from_phone_number_id = null, ?string $access_token = null, ?string $business_id = null)
    {
        $this->from_phone_number_id = $from_phone_number_id ?? '';
        $this->access_token = $access_token ?? '';
        $this->business_id = $business_id ?? '';

        $this->validate($this->from_phone_number_id, $this->access_token, $this->business_id);
    }

    /**
     * Returns the Facebook Whatsapp Access Token.
     */
    public function accessToken(): string
    {
        return $this->access_token;
    }

    /**
     * Returns the Facebook Phone Number ID.
     */
    public function fromPhoneNumberId(): string
    {
        return $this->from_phone_number_id;
    }

    /**
     * Returns the Business ID.
     */
    public function businessId(): string
    {
        return $this->business_id;
    }

    private function validate(string $from_phone_number_id, string $access_token, string $business_id): void
    {
        // validate by function type hinting
    }
}
