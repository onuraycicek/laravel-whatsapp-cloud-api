<?php

namespace WCA\WCA\Package\Message\CtaUrl;

use WCA\WCA\Package\Message\CtaUrl\Header;

final class TitleHeader extends Header
{
    protected string $title;

    public function __construct(string $title)
    {
        parent::__construct('text');

        $this->title = $title;
    }

    public function getBody(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->title,
        ];
    }
}
