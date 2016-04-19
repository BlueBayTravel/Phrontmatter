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
 * This is the phrontmatter formatter interface.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
interface PhrontmatterFormatterInterface
{
    public function deserialize($data);
}
