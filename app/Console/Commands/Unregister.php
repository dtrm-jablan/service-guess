<?php namespace Determine\Service\Guess\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Symfony\Component\Console\Input\InputArgument;

class Unregister extends Command
{
    //******************************************************************************
    //* Members
    //******************************************************************************

    /** @inheritdoc */
    protected $name = 'guess:unregister';
    /** @inheritdoc */
    protected $description = 'Unregister a suggester';

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

        /** @var Response $_response */
        $_response = \App::call('Determine\Service\Guess\Http\Controllers\Api\SuggestController@delete', ['index' => $_index, 'type' => $_type]);

        if (Response::HTTP_NOT_FOUND == ($_code = $_response->getStatusCode())) {
            $this->error('Error: suggester not found.');

            return 1;
        } elseif (Response::HTTP_OK != $_code) {
            $this->error('Error: suggester not deleted.');

            return 2;
        }

        $this->info('Suggester deleted.');

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
            ]);
    }
}
