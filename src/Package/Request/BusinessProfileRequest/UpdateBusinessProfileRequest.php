<?php

namespace WCA\WCA\Package\Request\BusinessProfileRequest;

use WCA\WCA\Package\Request;

final class UpdateBusinessProfileRequest extends Request
{
    /**
     * @var array Whatsapp profile information.
     */
    private array $information;

    /**
     * @var string WhatsApp Number Id from messages will sent.
     */
    private string $from_phone_number_id;

    public function __construct(array $information, string $access_token, string $from_phone_number_id, ?int $timeout = null)
    {
        $this->information = $information;
        $this->from_phone_number_id = $from_phone_number_id;

        parent::__construct($access_token, $timeout);
    }

    /**
     * Returns the raw form of the request.
     */
    public function body(): array
    {
        return array_merge(
            [
                'messaging_product' => 'whatsapp',
            ],
            $this->information
        );
    }

    /**
     * WhatsApp node path.
     */
    public function nodePath(): string
    {
        return $this->from_phone_number_id.'/whatsapp_business_profile';
    }
}
