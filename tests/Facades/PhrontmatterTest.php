<?php

/*
 * This file is part of Phrontmatter.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Tests\Phrontmatter\Facades;

use BlueBayTravel\Phrontmatter\Facades\Phrontmatter as PhrontmatterFacade;
use BlueBayTravel\Phrontmatter\Phrontmatter;
use BlueBayTravel\Tests\Phrontmatter\AbstractTestCase;
use GrahamCampbell\TestBenchCore\FacadeTrait;

class PhrontmatterTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'phrontmatter';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return PhrontmatterFacade::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return Phrontmatter::class;
    }
}
