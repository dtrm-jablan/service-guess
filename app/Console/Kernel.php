<?php namespace Determine\Service\Guess\Console;

use Determine\Service\Guess\Console\Commands\Register;
use Determine\Service\Guess\Console\Commands\Search;
use Determine\Service\Guess\Console\Commands\Seed;
use Determine\Service\Guess\Console\Commands\Show;
use Determine\Service\Guess\Console\Commands\Unregister;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @inheritdoc */
    protected $commands = [
        Register::class,
        Unregister::class,
        Seed::class,
        Search::class,
        Show::class,
    ];

    /** @inheritdoc */
    protected function schedule(Schedule $schedule)
    {
    }
}
