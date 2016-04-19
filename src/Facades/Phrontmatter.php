<?php

/*
 * This file is part of Phrontmatter.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Phrontmatter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the phrontmatter facade class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class Phrontmatter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'phrontmatter';
    }
}
