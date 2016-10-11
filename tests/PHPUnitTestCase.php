<?php

namespace Taisiya\PropelBundle;

class PHPUnitTestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', dirname(__DIR__));
    }
}
