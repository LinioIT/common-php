<?php

namespace Linio\Type;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testIsGettingKey()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals('bar', $dict->get('foo'));
    }

    public function testIsGettingMissingKey()
    {
        $dict = new Dictionary();
        $this->assertNull($dict->get('foo'));
    }

    public function testIsGettingMissingKeyWithDefaultValue()
    {
        $dict = new Dictionary();
        $this->assertEquals('default', $dict->get('foo', 'default'));
    }

    public function testIsConvertingToArray()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $dict->toArray());
    }

    public function testIsConvertingToString()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals('{"foo":"bar"}', (string) $dict);
    }

    public function testIsSettingKey()
    {
        $dict = new Dictionary();
        $dict->set('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $dict->toArray());
    }

    public function testIsCheckingKey()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertTrue($dict->has('foo'));
        $this->assertFalse($dict->has('baz'));
    }

    public function testIsCheckingValue()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertTrue($dict->contains('bar'));
        $this->assertFalse($dict->contains('baz'));
    }

    public function testIsRemovingKey()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $dict->remove('foo');
        $this->assertFalse($dict->has('foo'));
    }

    public function testIsClearing()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $dict->clear();
        $this->assertEmpty($dict->toArray());
    }

    public function testIsReplacing()
    {
        $dict = new Dictionary();
        $dict->replace(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $dict->toArray());
    }

    public function testIsCounting()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals(1, $dict->count());
    }

    public function testIsCheckingEmptiness()
    {
        $dict = new Dictionary();
        $this->assertTrue($dict->isEmpty());
        $dict->replace(['foo' => 'bar']);
        $this->assertFalse($dict->isEmpty());
    }

    public function testIsGettingAllKeys()
    {
        $dict = new Dictionary(['foo' => 'bar', 'fooz' => 'baz']);
        $this->assertEquals(['foo', 'fooz'], $dict->getKeys());
    }

    public function testIsEncodingToJson()
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals('{"foo":"bar"}', $dict);
    }
}
