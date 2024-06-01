<?php

namespace WCA\WCA\Commands;

use Illuminate\Console\Command;

class WCACommand extends Command
{
    public $signature = 'laravel-whatsapp-cloud-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
