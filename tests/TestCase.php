<?php

namespace Cmercado93\ChronospayApiBusiness\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp()
    {
        $this->makeDotEnv();
    }

    final protected function makeDotEnv()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }
}