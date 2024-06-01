<?php

namespace WCA\WCA\Package\Message\CtaUrl;

abstract class Header
{
    protected string $type;

    protected function __construct(string $type)
    {
        $this->type = $type;
    }

    abstract public function getBody(): array;
}
