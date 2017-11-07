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

interface Subscriber
{
    /**
     * @param Subscription $subscription
     * @param string       $sagaClass
     *
     * @return void
     */
    public function subscribe(Subscription $subscription, string $sagaClass): void;
}
