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

class ReflectionSubscriber implements Subscriber
{
    /**
     * @var string[]
     */
    private $prefixes;

    /**
     * @var array
     */
    private $exclude;

    /**
     * @param string[] $prefixes
     * @param array    $exclude
     */
    public function __construct(array $prefixes, array $exclude = [])
    {
        $filter = function ($value) {
            return \is_string($value) && \strlen($value) > 0;
        };

        $this->prefixes = \array_filter($prefixes, $filter);
        $this->exclude = \array_filter($exclude, $filter);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(Subscription $subscription, string $sagaClass): void
    {
        if (0 === \count($this->prefixes)) {
            return;
        }

        $reflection = new \ReflectionClass($sagaClass);

        foreach ($reflection->getMethods() as $method) {
            if (false === $this->passMethodRequirements($method)) {
                continue;
            }

            $methodName = $method->getName();

            if (true === \in_array($methodName, $this->exclude, true)) {
                continue;
            }

            foreach ($this->prefixes as $prefix) {
                if (0 !== \strpos($methodName, $prefix)) {
                    continue;
                }

                $parameter = $method->getParameters()[0];
                $eventClass = $parameter->getClass();

                if (null !== $eventClass) {
                    $subscription->attach($sagaClass, $eventClass->getName());
                }

                break;
            }
        }
    }

    /**
     * @param \ReflectionMethod $method
     *
     * @return bool
     */
    private function passMethodRequirements(\ReflectionMethod $method): bool
    {
        if ($method->isConstructor() ||
            $method->isDestructor() ||
            $method->isAbstract()
        ) {
            return false;
        }

        return $method->getNumberOfRequiredParameters() === 1;
    }
}
