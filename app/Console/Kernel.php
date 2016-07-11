<?php namespace Determine\Service\Guess\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @inheritdoc */
    protected $commands = [];

    /** @inheritdoc */
    protected function schedule(Schedule $schedule)
    {
    }
}
