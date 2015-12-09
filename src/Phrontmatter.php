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

use BlueBayTravel\Phrontmatter\Exceptions\InvalidFrontmatterFormatException;
use BlueBayTravel\Phrontmatter\Exceptions\UndefinedPropertyException;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class Phrontmatter
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
     * Parse the frontmatter file.
     *
     * @param string $content
     *
     * @return bool
     */
    public function parse($content)
    {
        // If the file doesn't immediately begin with a separator then this isn't a Frontmatter file.
        if (!Str::startsWith($content, '---')) {
            throw new InvalidFrontmatterFormatException('A valid Frontmatter document is expected to start with "---"');
        }

        // Split the document into three sections.
        $doc = explode('---', $content);

        if (count($doc) <= 1) { // Empty Document
            $this->content = '';
        } elseif (count($doc) === 2) { // Only Frontmatter
            $this->frontmatter = $doc[1];
        } else { // Frontmatter and content
            $this->frontmatter = $doc[1];
            $this->content = ltrim($doc[2]);
        }

        // Parse the Frontmatter content.
        $this->data = Yaml::parse($this->frontmatter);

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
     * Magic getter method.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        throw new UndefinedPropertyException("The key {$key} is undefined.");
    }
}
