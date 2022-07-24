<?php

namespace Cmercado93\ChronospayApiBusiness\Tests\Unit;

use Cmercado93\ChronospayApiBusiness\Auth;
use Cmercado93\ChronospayApiBusiness\Tests\TestCase;

class HttpTest extends TestCase
{
    public function test_auth()
    {
        $auth = new Auth(env('BASE_URL'));

        $auth->login(env('USERNAME'), env('PASSWORD'));

        $this->assertIsString($auth->getAccessToken());
    }
}