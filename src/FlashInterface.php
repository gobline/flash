<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Flash;

/**
 * Allows to store data across requests and objects with a session or request level scope.
 *
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
interface FlashInterface
{
    /**
     * Adds a flash variable for the current request.
     *
     * @param mixed $name
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function now($name, $value);

    /**
     * Adds a flash variable for the next request.
     *
     * @param mixed $name
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function next($name, $value);

    /**
     * Keeps flash variables set in the previous request so they will be available in the next request.
     */
    public function keep();

    /**
     * This method takes one or two arguments.
     * The first argument is the flash variable you want to get.
     * The second optional argument is the default value you want to get back
     * in case the flash variable hasn't been found.
     * If the second argument is omitted and the variable
     * hasn't been found, an exception will be thrown.
     *
     * @param mixed $args
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function get(...$args);

    /**
     * Check if the flash variable is available in the current request.
     *
     * @param mixed $name
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function has($name);

    /**
     * Returns an array of the flash variables
     * available in the current request.
     *
     * @return array
     */
    public function getIterator();

    /**
     * Returns an array of the flash variables
     * available in the current request.
     *
     * @return array
     */
    public function getArrayCopy();

    /**
     * Returns the number of flash variables available in the current request.
     *
     * @return int
     */
    public function count();
}
