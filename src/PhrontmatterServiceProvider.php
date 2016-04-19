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

use Illuminate\Support\ServiceProvider;

/**
 * This is the phrontmatter service provider class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class PhrontmatterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPhrontmatter();
    }

    /**
     * Register the phrontmatter class.
     *
     * @return void
     */
    protected function registerPhrontmatter()
    {
        $this->app->singleton('phrontmatter', function ($app) {
            return new Phrontmatter();
        });

        $this->app->alias('phrontmatter', Phrontmatter::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'phrontmatter',
        ];
    }
}
