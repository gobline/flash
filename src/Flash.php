<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Flash;

use Mendo\Session\NamespacedSession;
use \IteratorAggregate;
use \Countable;
use \ArrayIterator;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class Flash implements FlashInterface, IteratorAggregate, Countable
{
    const SESSION_NAMESPACE = 'Mendo_Flash';

    private $data;
    private $session;

    public function __construct()
    {
        $this->session = new NamespacedSession(self::SESSION_NAMESPACE);
        $this->data = $this->session->getArrayCopy();
        $this->session->clearAll();
    }

    /**
     * {@inheritdoc}
     */
    public function now($name, $value)
    {
        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

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

        $this->session->set($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function keep()
    {
        foreach ($this->data as $key => $value) {
            $this->session->set($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(...$args)
    {
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
        return array_key_exists($name, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getArrayCopy()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }
}
