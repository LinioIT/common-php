<?php

namespace Linio\Test;

use Nelmio\Alice\Fixtures\Loader;

abstract class UnitTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $fixtures = [];

    public function loadFixtures($file)
    {
        $loader = new Loader();
        $this->fixtures = $loader->load($file);
    }

    public function getMockForPdo($mockedMethods = [])
    {
        return $this->getMock('Linio\Test\PDOMock', $mockedMethods);
    }
}

class PDOMock extends \PDO
{
    public function __construct()
    {
    }
}
