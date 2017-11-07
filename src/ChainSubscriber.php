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

class ChainSubscriber implements Subscriber
{
    /**
     * @var Subscriber[]
     */
    private $subscribers;

    /**
     * @param Subscriber[] $subscribers
     */
    public function __construct(Subscriber ...$subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(Subscription $subscription, string $sagaClass): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->subscribe($subscription, $sagaClass);
        }
    }
}
