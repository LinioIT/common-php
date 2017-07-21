<?php

declare(strict_types=1);

namespace Linio\Common\Type;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testIsGettingKey(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals('bar', $dict->get('foo'));
    }

    public function testIsGettingMissingKey(): void
    {
        $dict = new Dictionary();
        $this->assertNull($dict->get('foo'));
    }

    public function testIsGettingMissingKeyWithDefaultValue(): void
    {
        $dict = new Dictionary();
        $this->assertEquals('default', $dict->get('foo', 'default'));
    }

    public function testIsConvertingToArray(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $dict->toArray());
    }

    public function testIsConvertingToString(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals('{"foo":"bar"}', (string) $dict);
    }

    public function testIsSettingKey(): void
    {
        $dict = new Dictionary();
        $dict->set('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $dict->toArray());
    }

    public function testIsCheckingKey(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertTrue($dict->has('foo'));
        $this->assertFalse($dict->has('baz'));
    }

    public function testIsCheckingValue(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertTrue($dict->contains('bar'));
        $this->assertFalse($dict->contains('baz'));
    }

    public function testIsRemovingKey(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $dict->remove('foo');
        $this->assertFalse($dict->has('foo'));
    }

    public function testIsClearing(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $dict->clear();
        $this->assertEmpty($dict->toArray());
    }

    public function testIsReplacing(): void
    {
        $dict = new Dictionary();
        $dict->replace(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $dict->toArray());
    }

    public function testIsCounting(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals(1, $dict->count());
    }

    public function testIsCheckingEmptiness(): void
    {
        $dict = new Dictionary();
        $this->assertTrue($dict->isEmpty());
        $dict->replace(['foo' => 'bar']);
        $this->assertFalse($dict->isEmpty());
    }

    public function testIsGettingAllKeys(): void
    {
        $dict = new Dictionary(['foo' => 'bar', 'fooz' => 'baz']);
        $this->assertEquals(['foo', 'fooz'], $dict->getKeys());
    }

    public function testIsEncodingToJson(): void
    {
        $dict = new Dictionary(['foo' => 'bar']);
        $this->assertEquals('{"foo":"bar"}', $dict);
    }
}
