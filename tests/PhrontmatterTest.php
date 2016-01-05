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

class PhrontmatterTest extends AbstractTestCase
{
    /**
     * @expectedException \BlueBayTravel\Phrontmatter\Exceptions\InvalidFrontmatterFormatException
     */
    public function testParseException()
    {
        $this->app->phrontmatter->parse('Foo bar baz bux');
    }

    public function testParseEmptyDocument()
    {
        $document = $this->app->phrontmatter->parse('---');

        $this->assertInstanceOf(Phrontmatter::class, $document);
    }

    public function testParseFrontmatterOnlyDocument()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\n---");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame('bar', $document->get('foo'));
        $this->assertSame('bar', $document->foo);
    }

    public function testParseFullDocument()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\n---\nThis is actual content!");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame('bar', $document->get('foo'));
        $this->assertSame('bar', $document->foo);
        $this->assertSame('This is actual content!', $document->getContent());
    }

    public function testParseFullDocumentWithJson()
    {
        $document = $this->app->phrontmatter->parse("---\n{\"foo\":\"bar\"}\n---\nThis is a document with JSON!", Phrontmatter::JSON);

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo' => 'bar'], $document->getData());
        $this->assertSame('This is a document with JSON!', $document->getContent());
    }

    public function testParseFullDocumentWithToml()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo = \"bar\"\n---\nThis is a document with TOML!", Phrontmatter::TOML);

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo' => 'bar'], $document->getData());
        $this->assertSame('This is a document with TOML!', $document->getContent());
    }

    public function testGetKeys()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: qux\n---\n");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo', 'baz'], $document->getKeys());
    }

    public function testGetData()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: qux\n---\n");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame(['foo' => 'bar', 'baz' => 'qux'], $document->getData());
    }

    /**
     * @expectedException \BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException
     */
    public function testUndefinedPropertyException()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\n---\nThis is actual content!");
        $this->assertNull($document->name);
    }

    public function testArrayAccessInterface()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: bux\n---\nThis is actual content!");

        $this->assertInstanceOf(ArrayAccess::class, $document);
        $this->assertTrue($document->offsetExists('foo'));
        $document->offsetSet('foo', 'james');

        $this->assertSame('james', $document->offsetGet('foo'));
        $document->offsetUnset('foo');
    }

    public function testCountableInterface()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: bux\n---\nThis is actual content!");

        $this->assertInstanceOf(Countable::class, $document);
        $this->assertEquals(2, $document->count());
    }
}
