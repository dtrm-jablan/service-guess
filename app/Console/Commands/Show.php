<?php namespace Determine\Service\Guess\Console\Commands;

use Determine\Service\Guess\Http\Controllers\Api\SuggestController;
use Determine\Service\Guess\Utility\ClientBuilder;
use Illuminate\Console\Command;

class Show extends Command
{
    //******************************************************************************
    //* Members
    //******************************************************************************

    /** @inheritdoc */
    protected $name = 'guess:show';
    /** @inheritdoc */
    protected $description = 'List configured suggesters';

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $_count = 0;
        $_client = ClientBuilder::fromConfig(config('guess.elastic', []));
        $_response = $_client->indices()->get(['index' => '_all']);

        if (!is_array($_response)) {
            $this->error('Error retrieving list of suggesters.');

            return 1;
        }

        foreach ($_response as $_key => $_value) {
            $_index = $_key;
            $_uuid = array_get($_value, 'settings.index.uuid');

            foreach (array_get($_value, 'mappings', []) as $_mapKey => $_mapValue) {
                if (null !== ($_properties = array_get($_mapValue, 'properties'))) {
                    if (null !== array_get($_properties, SuggestController::SUGGEST_FIELD)) {
                        $this->output->writeln(($_uuid ?: 'index') . ': ' . $_index . '/' . $_mapKey);
                        $_count++;
                    }
                }
            }
        }

        if ($_count) {
            $this->info(number_format($_count, 0) . ' suggester(s) found.');
        }
    }
}
