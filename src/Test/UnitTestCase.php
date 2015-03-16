<?php

namespace Linio\Test;

abstract class UnitTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $fixtures = [];

    public function loadFixtures($file)
    {
        $loader = new \Nelmio\Alice\Loader\Yaml();
        $this->fixtures = $loader->load($file);
    }

    public function getMockForPdo($mockedMethods = [])
    {
        return $this->getMock('Linio\Test\PDOMock', $mockedMethods);
    }
}

// @codingStandardsIgnoreStart
class PDOMock extends \PDO
{
    public function __construct()
    {
    }
}
// @codingStandardsIgnoreEnd
