<?php

namespace WCA\WCA;

use WCA\WCA\Package\Message\Media\MediaID;
use WCA\WCA\Package\Message\Template\Component;
use WCA\WCA\Package\Response;

class WCA
{
    /**
     * @var WCAApp The WCAApp entity.
     */
    protected WCAApp $app;

    /**
     * @var Package\Client The WhatsApp Cloud Api client service.
     */
    protected Package\Client $client;

    /**
     * @var int The WhatsApp Cloud Api client timeout.
     */
    protected ?int $timeout;

    /**
     * The WhatsApp Message ID to reply to.
     */
    private ?string $reply_to = null;

    public function __construct(array $config)
    {
        $config = array_merge([
            'from_phone_number_id' => null,
            'access_token' => $this->claimAccessToken(),
            'business_id' => '',
            'graph_version' => config('whatsapp-cloud-api.graph_version'),
            'client_handler' => null,
            'timeout' => null,
        ], $config);

        $this->app = new WCAApp(
            $config['from_phone_number_id'],
            $config['access_token'],
            $config['business_id']
        );
        $this->timeout = $config['timeout'];
        $this->client = new Package\Client($config['graph_version'], $config['client_handler']);
    }

    private function claimAccessToken()
    {
        return config('whatsapp-cloud-api.access_token');
    }

    /**
     * Sends a Whatsapp text message.
     *
     * @param string WhatsApp ID or phone number for the person you want to send a message to.
     * @param string The body of the text message.
     * @param bool Determines if show a preview box for URLs contained in the text message.
     *
     * @throws Response\ResponseException
     */
    public function sendTextMessage(string $to, string $text, bool $preview_url = false): Response
    {
        $message = new Package\Message\TextMessage($to, $text, $preview_url, $this->reply_to);
        $request = new Package\Request\MessageRequest\RequestTextMessage(
            $message,
            $this->app->accessToken(),
            $this->app->fromPhoneNumberId(),
            $this->timeout
        );

        return $this->client->sendMessage($request);
    }

    /**
     * Sends a message template.
     *
     * @param  string  $to  WhatsApp ID or phone number for the person you want to send a message to.
     * @param  string  $template_name  Name of the template to send.
     * @param  string  $language  Language code
     * @param  Component|null  $component  Component parameters of a template
     *
     * @link https://developers.facebook.com/docs/whatsapp/api/messages/message-templates#supported-languages See language codes supported.
     *
     * @throws Response\ResponseException
     */
    public function sendTemplate(string $to, string $template_name, string $language = 'en_US', ?Component $components = null): Response
    {
        $message = new Package\Message\TemplateMessage($to, $template_name, $language, $components, $this->reply_to);
        $request = new Package\Request\MessageRequest\RequestTemplateMessage(
            $message,
            $this->app->accessToken(),
            $this->app->fromPhoneNumberId(),
            $this->timeout
        );

        return $this->client->sendMessage($request);
    }

    /**
     * Sends a document uploaded to the WhatsApp Cloud servers by it Media ID or you also
     * can put any public URL of some document uploaded on Internet.
     *
     * @param  string  $to  WhatsApp ID or phone number for the person you want to send a message to.
     * @param  MediaID  $document_id  WhatsApp Media ID or any Internet public document link.
     *
     * @throws Response\ResponseException
     */
    public function sendDocument(string $to, MediaID $document_id, string $name, ?string $caption): Response
    {
        $message = new Package\Message\DocumentMessage($to, $document_id, $name, $caption, $this->reply_to);
        $request = new Package\Request\MessageRequest\RequestDocumentMessage(
            $message,
            $this->app->accessToken(),
            $this->app->fromPhoneNumberId(),
            $this->timeout
        );

        return $this->client->sendMessage($request);
    }

    /**
     * Sends a Whatsapp text message.
     *
     * @param string WhatsApp ID or phone number for the person you want to send a message to.
     * @param string The body of the text message.
     * @param bool Determines if show a preview box for URLs contained in the text message.
     *
     * @throws Response\ResponseException
     */
    public function getBusinessPhoneNumbers(): Response
    {
        $request = new Package\Request\BusinessPhoneNumberRequest\BusinessPhoneNumberRequest(
            $this->app->accessToken(),
            $this->app->businessId(),
            $this->timeout
        );

        return $this->client->getBusinessPhoneNumbers($request);
    }

    /**
     * Get Business Profile
     *
     * @param  string  $fields  WhatsApp profile fields.
     *
     * @throws Response\ResponseException
     */
    public function businessProfile(string $fields): Response
    {
        $request = new Package\Request\BusinessProfileRequest\BusinessProfileRequest(
            $fields,
            $this->app->accessToken(),
            $this->app->fromPhoneNumberId(),
            $this->timeout
        );

        return $this->client->businessProfile($request);
    }

    /**
     * Upload a media file (image, audio, video...) to Facebook servers.
     *
     * @param  string  $file_path  Path of the media file to upload.
     *
     * @throws Response\ResponseException
     */
    public function uploadMedia(string $file_path): Response
    {
        $request = new Package\Request\MediaRequest\UploadMediaRequest(
            $file_path,
            $this->app->fromPhoneNumberId(),
            $this->app->accessToken(),
            $this->timeout
        );

        return $this->client->uploadMedia($request);
    }

    /**
     * Mark a message as read
     *
     * @param  string  $message_id  WhatsApp Message Id will be marked as read.
     *
     * @throws Response\ResponseException
     */
    public function markMessageAsRead(string $message_id): Response
    {
        $request = new Package\Request\MessageReadRequest(
            $message_id,
            $this->app->accessToken(),
            $this->app->fromPhoneNumberId(),
            $this->timeout
        );

        return $this->client->sendMessage($request);
    }

    /**
     * Get Templates
     *
     * @throws Response\ResponseException
     */
    public function getBusinessTemplateMessages(?string $after = ''): Response
    {
        $request = new Package\Request\BusinessTemplateRequest\BusinessTemplateRequest(
            $this->app->accessToken(),
            $this->app->businessId(),
            $after,
            $this->timeout
        );

        return $this->client->getTemplates($request);
    }

    /**
     * Download a media file (image, audio, video...) from Facebook servers.
     *
     * @param  string  $media_id  Id of the media uploaded with the `uploadMedia` method
     *
     * @throws Response\ResponseException
     */
    public function downloadMedia(string $media_id): Response
    {
        $request = new Package\Request\MediaRequest\DownloadMediaRequest(
            $media_id,
            $this->app->accessToken(),
            $this->timeout
        );

        return $this->client->downloadMedia($request);
    }

    /**
     * Returns the Facebook Whatsapp Access Token.
     */
    public function accessToken(): string
    {
        return $this->app->accessToken();
    }

    /**
     * Returns the Facebook Phone Number ID.
     */
    public function fromPhoneNumberId(): string
    {
        return $this->app->fromPhoneNumberId();
    }

    /**
     * @param  string  $message_id  The WhatsApp Message ID to reply to.
     */
    public function replyTo(string $message_id): self
    {
        $this->reply_to = $message_id;

        return $this;
    }
}
