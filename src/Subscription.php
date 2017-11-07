<?php
/*
 * This file is part of PHPinnacle/Saga.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PHPinnacle\Saga;

class Subscription
{
    /**
     * @var string[]
     */
    private $eventMap = [];

    /**
     * @param string $sagaClass
     * @param string $eventClass
     *
     * @return void
     */
    public function attach(string $sagaClass, string $eventClass): void
    {
        $this->eventMap[$sagaClass][] = $eventClass;
    }
}
