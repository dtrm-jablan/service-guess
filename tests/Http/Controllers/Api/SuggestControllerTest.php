<?php
/**
 * This file is part of the DreamFactory Services Platform(tm) (DSP)
 *
 * DreamFactory Services Platform(tm) <http://github.com/dreamfactorysoftware/dsp-core>
 * Copyright 2012-2013 DreamFactory Software, Inc. <developer-support@dreamfactory.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Determine\Tests\Http\Controllers\Api;

use Determine\Service\Guess\Utility\ClientBuilder;
use Elasticsearch\Client;

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

    //******************************************************************************
    //* Members
    //******************************************************************************

    /**
     * @var Client
     */
    protected static $client;

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /** @inheritdoc */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::$client = ClientBuilder::fromConfig(config('guess.elastic'));
    }

    public function testCreate()
    {
        //  Create a new index
        $_server = $this->transformHeadersToServerVars($_headers = []);
        $_response = $this->call('POST', '/api/suggest/create/' . static::TEST_INDEX_NAME . '/' . static::TEST_TYPE_NAME, [], [], [], $_server);
        $_result = $_response->getContent();

        $this->assertNotEmpty($_result);
        $this->assertArrayHasKey('acknowledged', $_result);
    }
}
