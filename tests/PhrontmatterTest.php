<?php

/*
 * This file is part of Phrontmatter.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Tests\Phrontmatter;

use ArrayAccess;
use BlueBayTravel\Phrontmatter\Phrontmatter;
use Countable;
use GrahamCampbell\TestBench\AbstractTestCase as BaseAbstractTestCase;

class PhrontmatterTest extends BaseAbstractTestCase
{
    /**
     * @expectedException \BlueBayTravel\Phrontmatter\Exceptions\InvalidFrontmatterFormatException
     */
    public function testParseException()
    {
        $this->getPhrontmatter()->parse('Foo bar baz bux');
    }

    public function testParseEmptyDocument()
    {
        $document = $this->getPhrontmatter()->parse('---');

        $this->assertInstanceOf(Phrontmatter::class, $document);
    }

    public function testParseFrontmatterOnlyDocument()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\n---");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame('bar', $document->get('foo'));
        $this->assertSame('bar', $document->foo);
    }

    public function testParseFullDocument()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\n---\nThis is actual content!");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame('bar', $document->get('foo'));
        $this->assertSame('bar', $document->foo);
        $this->assertSame('This is actual content!', $document->getContent());
    }

    public function testParseFullDocumentWithJson()
    {
        $document = $this->getPhrontmatter()->parse("---\n{\"foo\":\"bar\"}\n---\nThis is a document with JSON!", Phrontmatter::JSON);

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo' => 'bar'], $document->getData());
        $this->assertSame('This is a document with JSON!', $document->getContent());
    }

    public function testParseFullDocumentWithToml()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo = \"bar\"\n---\nThis is a document with TOML!", Phrontmatter::TOML);

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo' => 'bar'], $document->getData());
        $this->assertSame('This is a document with TOML!', $document->getContent());
    }

    public function testGetKeys()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\nbaz: qux\n---\n");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo', 'baz'], $document->getKeys());
    }

    public function testGetData()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\nbaz: qux\n---\n");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo' => 'bar', 'baz' => 'qux'], $document->getData());
    }

    /**
     * @expectedException \BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException
     */
    public function testUndefinedPropertyException()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\n---\nThis is actual content!");
        $this->assertNull($document->name);
    }

    public function testArrayAccessInterface()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\nbaz: bux\n---\nThis is actual content!");

        $this->assertInstanceOf(ArrayAccess::class, $document);
        $this->assertTrue($document->offsetExists('foo'));
        $document->offsetSet('foo', 'james');

        $this->assertSame('james', $document->offsetGet('foo'));
        $document->offsetUnset('foo');
    }

    public function testCountableInterface()
    {
        $document = $this->getPhrontmatter()->parse("---\nfoo: bar\nbaz: bux\n---\nThis is actual content!");

        $this->assertInstanceOf(Countable::class, $document);
        $this->assertEquals(2, $document->count());
    }

    protected function getPhrontmatter()
    {
        return new Phrontmatter();
    }
}
