<?php

/*
 * This file is part of Phrontmatter.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Phrontmatter\Formatters;

use Toml\Parser;

/**
 * This is the toml formatter class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class TomlFormatter implements PhrontmatterFormatterInterface
{
    /**
     * Deserializes Frontmatter data in the Toml format.
     *
     * @param string $data
     *
     * @return object
     */
    public function deserialize($data)
    {
        return Parser::fromString($data);
    }
}
