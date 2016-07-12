<?php namespace Determine\Service\Tests\Http\Controllers\Api;

class SuggestControllerTest extends \TestCase
{
    //******************************************************************************
    //* Constants
    //******************************************************************************

    /**
     * @var string
     */
    const TEST_INDEX_NAME = 'test_index';
    /**
     * @var string
     */
    const TEST_TYPE_NAME = 'type_xyz';
    /**
     * @var string
     */
    const TEST_TEXT = 'f';

    //******************************************************************************
    //* Members
    //******************************************************************************

    /**
     * @var array
     */
    protected $config;
    /**
     * @var array
     */
    protected $server;

    //******************************************************************************
    //* Methods
    //******************************************************************************

    protected function setUp()
    {
        parent::setUp();

        $this->config = json_decode(file_get_contents(__DIR__ . '/suggest.config.json'), true);
        $this->server = $this->transformHeadersToServerVars($_headers = []);
    }

    /**
     * Test the register API call
     *
     * @covers SuggestController::create
     */
    public function testRegister()
    {
        $_payload = [
            'name'        => 'string',
            'code'        => 'string',
            'description' => 'string',
        ];

        //  Create a new index
        $_response =
            $this->call('POST', '/api/suggest/register/' . static::TEST_INDEX_NAME . '/' . static::TEST_TYPE_NAME, [], [], [], $this->server, $_payload);

        $this->assertNotEmpty($_json = $_response->getContent());

        if (!is_array($_json)) {
            $_json = json_decode($_json, true);
        }

        $this->assertTrue(false !== $_json && !empty($_json));
        $this->assertArrayHasKey('acknowledged', $_json);
    }

    /**
     * Seed the index for searching
     *
     * @covers DocController::seed
     */
    public function testSeed()
    {
        $_payload = ['seeds' => array_get($this->config, 'seeds', [])];
        logger('payload', $_payload);

        //  Create a new index
        $_response = $this->call('POST', '/api/suggest/seed/' . static::TEST_INDEX_NAME . '/' . static::TEST_TYPE_NAME, [], [], [], $this->server, $_payload);

        $this->assertNotEmpty($_json = $_response->getContent());
        $this->assertTrue(false !== ($_result = json_decode($_json, true)) && !empty($_result));
        $this->assertNotEmpty($_result);
    }

    /**
     * Search
     *
     * @covers DocController::suggest
     */
    public function testSearch()
    {
        //  Create a new index
        $_response =
            $this->call('GET',
                '/api/suggest/search/' . static::TEST_INDEX_NAME . '/' . static::TEST_TYPE_NAME . '/' . static::TEST_TEXT,
                [],
                [],
                [],
                $this->server);

        $this->assertNotEmpty($_json = $_response->getContent());
        $this->assertTrue(false !== ($_result = json_decode($_json, true)) && !empty($_result));
        $this->assertNotEmpty($_result);
        logger('[tests.suggest] search results', $_result);
    }

    /**
     * Test the register API call
     *
     * @covers SuggestController::delete
     */
    public function testUnregister()
    {
        //  Delete the new index
        $_response = $this->call('DELETE', '/api/index/' . static::TEST_INDEX_NAME, [], [], [], $this->server);

        $this->assertNotEmpty($_json = $_response->getContent());

        if (!is_array($_json)) {
            $_json = json_decode($_json, true);
        }

        $this->assertTrue(false !== $_json && !empty($_json));
        $this->assertArrayHasKey('acknowledged', $_json);
    }
}
