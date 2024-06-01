<?php

namespace WCA\WCA\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \WCA\WCA\WCA
 */
class WCA extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \WCA\WCA\WCA::class;
    }
}
