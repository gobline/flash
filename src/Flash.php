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

use Gobline\Session\NamespacedSession;
use \IteratorAggregate;
use \Countable;
use \ArrayIterator;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class Flash implements FlashInterface, IteratorAggregate, Countable
{
    const SESSION_NAMESPACE = 'Gobline_Flash';

    private $data;
    private $session;
    private $initialized = false;

    public function __construct()
    {
        $this->session = new NamespacedSession(self::SESSION_NAMESPACE);
    }

    public function initialize()
    {
        $this->data = $this->session->getArrayCopy();
        $this->session->clearAll();

        $this->initialized = true;
    }

    public function checkInitialized()
    {
        if (!$this->initialized) {
            throw new \RuntimeException('Flash has not been initialized');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function now($name, $value)
    {
        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

        $this->checkInitialized();

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function next($name, $value)
    {
        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

        $this->checkInitialized();

        $this->session->set($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function keep()
    {
        $this->checkInitialized();

        foreach ($this->data as $key => $value) {
            $this->session->set($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(...$args)
    {
        $this->checkInitialized();

        switch (count($args)) {
            default:
                throw new \InvalidArgumentException('get() takes one or two arguments');
            case 1:
                if (!$this->has($args[0])) {
                    throw new \InvalidArgumentException('Flash variable "'.$args[0].'" not found');
                }

                return $this->data[$args[0]];
            case 2:
                if (!$this->has($args[0])) {
                    return $args[1];
                }

                return $this->data[$args[0]];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        $this->checkInitialized();

        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

        return array_key_exists($name, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->checkInitialized();

        return new ArrayIterator($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getArrayCopy()
    {
        $this->checkInitialized();

        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $this->checkInitialized();

        return count($this->data);
    }
}
