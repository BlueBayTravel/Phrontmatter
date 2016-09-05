<?php

/*
 * This file is part of Phrontmatter.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Phrontmatter;

use ArrayAccess;
use BlueBayTravel\Phrontmatter\Exceptions\InvalidFrontmatterFormatException;
use BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException;
use Countable;
use Illuminate\Support\Str;

/**
 * This is the phrontmatter class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class Phrontmatter implements ArrayAccess, Countable
{
    /**
     * The frontmatter data.
     *
     * @var string[]
     */
    protected $data;

    /**
     * Original frontmatter content.
     *
     * @var string
     */
    protected $frontmatter;

    /**
     * Content found after frontmatter.
     *
     * @var string
     */
    protected $content;

    /**
     * JSON formatter constant.
     *
     * @var string
     */
    const JSON = '\\BlueBayTravel\\Phrontmatter\\Formatters\\JsonFormatter';

    /**
     * TOML formatter constant.
     *
     * @var string
     */
    const TOML = '\\BlueBayTravel\\Phrontmatter\\Formatters\\TomlFormatter';

    /**
     * YAML formatter constant.
     *
     * @var string
     */
    const YAML = '\\BlueBayTravel\\Phrontmatter\\Formatters\\YamlFormatter';

    /**
     * Parse the frontmatter file.
     *
     * @param string      $content
     * @param null|string $formatter
     *
     * @return bool
     */
    public function parse($content, $formatter = null)
    {
        if ($formatter === null) {
            $formatter = self::YAML;
        }

        $parser = new $formatter();

        // If the file doesn't immediately begin with a separator then this isn't a Frontmatter file.
        if (!Str::startsWith($content, '---')) {
            throw new InvalidFrontmatterFormatException('A valid Frontmatter document is expected to start with "---"');
        }

        // Split the document into three sections.
        $doc = explode('---', $content);

        if (count($doc) <= 1) { // Empty Document
            $this->content = '';
        } elseif (count($doc) === 2) { // Only Frontmatter
            $this->frontmatter = trim($doc[1]);
        } else { // Frontmatter and content
            // It's possible that the Markdown content contains a HR (---) tag. We should merge these values back together.
            $content = $doc[2];

            if (count($doc) > 3) {
                $content = '';
                for ($i = 3; $i < count($doc); $i++) {
                    $content .= $doc[$i];
                }
            }

            $this->frontmatter = trim($doc[1]);
            $this->content = ltrim($content);
        }

        // Parse the Frontmatter content.
        $this->data = $parser->deserialize($this->frontmatter);

        return $this;
    }

    /**
     * Returns a value from frontmatter.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        throw new UndefinedPropertyException("The key {$key} is undefined.");
    }

    /**
     * Return the keys available in the frontmatter document.
     *
     * @return string[]
     */
    public function getKeys()
    {
        return array_keys($this->data);
    }

    /**
     * Returns the content section of the document.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the data array.
     *
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Magic getter method.
     *
     * @param string $key
     *
     * @throws \BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException description
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (!isset($this->data[$key])) {
            throw new UndefinedPropertyException("The key {$key} is undefined.");
        }

        return $this->data[$key];
    }

    /**
     * Magic setter method.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @throws \BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException description
     *
     * @return void
     */
    public function __set($key, $value)
    {
        if (!isset($this->data[$key])) {
            throw new UndefinedPropertyException("The key {$key} is undefined.");
        }

        $this->data[$key] = $value;
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param string $offset
     * @param mixed  $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Whether or not an offset exists.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Unsets an offset.
     *
     * @param string $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * Returns the value at specified offset.
     *
     * @param string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }

    /**
     * Count the number of items in the dataset.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
}
