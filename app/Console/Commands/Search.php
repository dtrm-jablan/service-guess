<?php

namespace Determine\Service\Guess\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Symfony\Component\Console\Input\InputArgument;

class Search extends Command
{
    //******************************************************************************
    //* Members
    //******************************************************************************

    /** @inheritdoc */
    protected $name = 'guess:search';
    /** @inheritdoc */
    protected $description = 'Use a suggester';

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
        $_text = $this->argument('text');

        /** @var Response $_response */
        $_response = \App::call(
            'Determine\Service\Guess\Http\Controllers\Api\DocController@suggest',
            ['index' => $_index, 'type' => $_type, 'text' => $_text]
        );

        if (Response::HTTP_OK !== $_response->getStatusCode()) {
            $this->error('Error: suggester not found.');

            return 1;
        }

        if (is_string($_data = $_response->getContent())) {
            if (false === ($_data = json_decode($_data, true)) || empty($_data)) {
                $this->error('Error: response received is invalid.');

                return 2;
            }
        }

        array_forget($_data, '_shards');

        if (empty($_data)) {
            $this->info('No data found.');
        } else {
            foreach ($_data as $_key => $_value) {
                $this->output->writeln(print_r($_value, true));
            }
        }

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
                    'text',
                    InputArgument::REQUIRED,
                    'The text to search',
                ],
            ]);
    }
}
