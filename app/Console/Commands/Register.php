<?php namespace Determine\Service\Guess\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Symfony\Component\Console\Input\InputArgument;

class Register extends Command
{
    //******************************************************************************
    //* Members
    //******************************************************************************

    /** @inheritdoc */
    protected $name = 'guess:register';
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

        //  Clean up the properties
        $_properties = $this->argument('properties');

        if (is_string($_properties)) {
            $_props = [];
            foreach (explode(',', $_properties) as $_key => $_prop) {
                $_props[trim($_prop)] = 'string';
            }

            $_properties = $_props;
        }

        if (!is_array($_properties) || empty($_properties)) {
            $this->error('Invalid or missing properties. These are required for registration.');

            return 1;
        }

        /** @var Response $_response */
        $_response = \App::call(
            'Determine\Service\Guess\Http\Controllers\Api\SuggestController@create',
            ['index' => $_index, 'type' => $_type, 'properties' => $_properties]
        );

        if (Response::HTTP_OK !== $_response->getStatusCode()) {
            $this->error('Error: suggester not registered.');

            return 2;
        }

        $this->info('Suggester created.');

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
                    'properties',
                    InputArgument::REQUIRED,
                    'Comma-separated list of fields included in this suggester',
                ],
            ]);
    }
}
