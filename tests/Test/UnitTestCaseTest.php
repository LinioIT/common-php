<?php

declare(strict_types=1);

namespace Linio\Test;

class UnitTestCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCreatingPDOMock()
    {
        $testCase = $this->getMockForAbstractClass('Linio\Test\UnitTestCase');
        $this->assertInstanceOf('\PDO', $testCase->getMockForPdo());
    }

    public function testIsLoadingFixture()
    {
        $filepath = tempnam(sys_get_temp_dir(), 'fix') . '.yml';
        file_put_contents($filepath, $this->getFixtureFileContent());

        $testCase = new UnitTestCaseDouble();
        $actual = $testCase->loadFixtures($filepath);
        @unlink($filepath);

        $this->assertInternalType('array', $testCase->getFixtures());
        $this->assertCount(1, $testCase->getFixtures());
        $fixtures = $testCase->getFixtures();
        $this->assertInstanceOf('\Linio\Test\TestEntity', $fixtures['fixture0']);
    }

    protected function getFixtureFileContent()
    {
        return <<<FIXTURE
Linio\Test\TestEntity:
    fixture0:
        name: fixture_name
FIXTURE;
    }
}

// @codingStandardsIgnoreStart
class UnitTestCaseDouble extends UnitTestCase
{
    /**
     * @return array
     */
    public function getFixtures()
    {
        return $this->fixtures;
    }
}

class TestEntity
{
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
// @codingStandardsIgnoreEnd
