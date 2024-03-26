<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher;

/**
 * A read-only proxy for an event dispatcher.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class ImmutableEventDispatcher implements EventDispatcherInterface
{
<<<<<<< HEAD
    private EventDispatcherInterface $dispatcher;
=======
    private $dispatcher;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function dispatch(object $event, string $eventName = null): object
    {
        return $this->dispatcher->dispatch($event, $eventName);
    }

    /**
<<<<<<< HEAD
     * @return never
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addListener(string $eventName, callable|array $listener, int $priority = 0)
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }

    /**
<<<<<<< HEAD
     * @return never
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }

    /**
<<<<<<< HEAD
     * @return never
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function removeListener(string $eventName, callable|array $listener)
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }

    /**
<<<<<<< HEAD
     * @return never
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getListeners(string $eventName = null): array
    {
        return $this->dispatcher->getListeners($eventName);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getListenerPriority(string $eventName, callable|array $listener): ?int
    {
        return $this->dispatcher->getListenerPriority($eventName, $listener);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function hasListeners(string $eventName = null): bool
    {
        return $this->dispatcher->hasListeners($eventName);
    }
}
