<?php

namespace WCA\WCA\Package\Request\MediaRequest;

use WCA\WCA\Package\Request;

final class DownloadMediaRequest extends Request
{
    /**
     * @var string Id of the media uploaded to the Facebook servers.
     */
    private string $media_id;

    /**
     * Creates a new Media Request instance.
     */
    public function __construct(string $media_id, string $access_token, ?int $timeout = null)
    {
        $this->media_id = $media_id;

        parent::__construct($access_token, $timeout);
    }

    /**
     * Media Identifier (Id).
     */
    public function mediaId(): string
    {
        return $this->media_id;
    }

    /**
     * WhatsApp node path.
     */
    public function nodePath(): string
    {
        return $this->media_id;
    }
}
