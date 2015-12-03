<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Gobline\Flash\Flash;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class FlashTest extends PHPUnit_Framework_TestCase
{
    private $flash;

    public function setUp()
    {
        @session_destroy();
        @session_start();

        $this->flash = new Flash();
        $this->flash->initialize();
    }

    public function testFlashNext()
    {
        $this->flash->next('msg', 'Hello world!');
        $this->assertNull($this->flash->get('msg', null)); // msg is only available in the next request
    }

    public function testFlashNow()
    {
        $this->flash->now('msg', 'Hello world!');
        $this->assertSame('Hello world!', $this->flash->get('msg', null)); // msg is available only in the current request
    }

    public function testFlashGetNonExistent()
    {
        $this->setExpectedException('\InvalidArgumentException', 'not found');
        $this->flash->get('msg');
    }

    public function testFlashCountNbData()
    {
        $this->flash->now('msg1', 'hello');
        $this->assertSame(1, count($this->flash));

        $this->flash->now('msg2', 'world');
        $this->assertSame(2, count($this->flash));
    }
}
