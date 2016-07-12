<?php namespace Determine\Service\Guess\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Symfony\Component\Console\Input\InputArgument;

class Seed extends Command
{
    //******************************************************************************
    //* Members
    //******************************************************************************

    /** @inheritdoc */
    protected $name = 'guess:seed';
    /** @inheritdoc */
    protected $description = 'Register a suggester';

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
        $_index = $this->argument('index-name');
        $_type = $this->argument('type-name');
        $_record = $this->argument('record');

        if (false === ($_data = json_decode($_record, true)) || empty($_data)) {
            $this->error('Invalid or missing seed data ("record" parameter).');

            return 1;
        }

        /** @var Response $_response */
        $_response = \App::call(
            'Determine\Service\Guess\Http\Controllers\Api\DocController@seed',
            ['index' => $_index, 'type' => $_type, 'properties' => $_data]
        );

        if (Response::HTTP_OK !== $_response->getStatusCode()) {
            $this->error('Error: suggester not seeded.');

            return 2;
        }

        $this->info('Suggester seeded.');

        return 0;
    }

    /** @inheritdoc */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(),
            [
                [
                    'index-name',
                    InputArgument::REQUIRED,
                    'The id of index for this suggester',
                ],
                [
                    'type-name',
                    InputArgument::REQUIRED,
                    'The document type of the suggester index',
                ],
                [
                    'record',
                    InputArgument::REQUIRED,
                    'A JSON string containing the seed data',
                ],
            ]);
    }
}
