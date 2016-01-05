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
        $document = $this->app->phrontmatter->parse("---\nfoo: bar---");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame('bar', $document->get('foo'));
        $this->assertSame('bar', $document->foo);
    }

    public function testParseFullDocument()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar---\nThis is actual content!");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame('bar', $document->get('foo'));
        $this->assertSame('bar', $document->foo);
        $this->assertSame('This is actual content!', $document->getContent());
    }

    public function testGetKeys()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: qux---\n");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame($document->getKeys(), ['foo', 'baz']);
    }

    public function testGetData()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: qux---\n");

        $this->assertInstanceOf(Phrontmatter::class, $document);
        $this->assertSame($document->getData(), ['foo' => 'bar', 'baz' => 'qux']);
    }

    /**
     * @expectedException \BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException
     */
    public function testUndefinedPropertyException()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar---\nThis is actual content!");
        $this->assertNull($document->name);
    }

    public function testArrayAccessInterface()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: bux---\nThis is actual content!");

        $this->assertInstanceOf(ArrayAccess::class, $document);
        $this->assertTrue($document->offsetExists('foo'));
        $document->offsetSet('foo', 'james');

        $this->assertSame('james', $document->offsetGet('foo'));
        $document->offsetUnset('foo');
    }

    public function testCountableInterface()
    {
        $document = $this->app->phrontmatter->parse("---\nfoo: bar\nbaz: bux---\nThis is actual content!");

        $this->assertInstanceOf(Countable::class, $document);
        $this->assertEquals(2, $document->count());
    }
}
