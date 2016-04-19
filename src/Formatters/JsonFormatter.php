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

/**
 * This is the json formatter class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class JsonFormatter implements PhrontmatterFormatterInterface
{
    /**
     * Deserializes Frontmatter data in the JSON format.
     *
     * @param string $data
     *
     * @return object
     */
    public function deserialize($data)
    {
        return json_decode($data, true);
    }
}
