<?php

namespace WCA\WCA\Package\Request;

interface RequestWithBody
{
    /**
     * Returns the raw body of the request.
     */
    public function body(): array;
}
