<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Flash\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Mendo\Flash\Flash;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class FlashServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'flash')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference] = function ($c) {
            return new Flash();
        };
    }
}
