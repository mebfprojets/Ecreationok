<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\Debug;

use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Log\LoggerInterface;
<<<<<<< HEAD
use Symfony\Component\EventDispatcher\EventDispatcher;
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Service\ResetInterface;

/**
 * Collects some data about event listeners.
 *
 * This event dispatcher delegates the dispatching to another one.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TraceableEventDispatcher implements EventDispatcherInterface, ResetInterface
{
    protected $logger;
    protected $stopwatch;

    /**
     * @var \SplObjectStorage<WrappedListener, array{string, string}>|null
     */
    private ?\SplObjectStorage $callStack = null;
<<<<<<< HEAD
    private EventDispatcherInterface $dispatcher;
    private array $wrappedListeners = [];
    private array $orphanedEvents = [];
    private ?RequestStack $requestStack;
=======
    private $dispatcher;
    private array $wrappedListeners = [];
    private array $orphanedEvents = [];
    private $requestStack;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    private string $currentRequestHash = '';

    public function __construct(EventDispatcherInterface $dispatcher, Stopwatch $stopwatch, LoggerInterface $logger = null, RequestStack $requestStack = null)
    {
        $this->dispatcher = $dispatcher;
        $this->stopwatch = $stopwatch;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addListener(string $eventName, callable|array $listener, int $priority = 0)
    {
        $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function removeListener(string $eventName, callable|array $listener)
    {
        if (isset($this->wrappedListeners[$eventName])) {
            foreach ($this->wrappedListeners[$eventName] as $index => $wrappedListener) {
                if ($wrappedListener->getWrappedListener() === $listener || ($listener instanceof \Closure && $wrappedListener->getWrappedListener() == $listener)) {
                    $listener = $wrappedListener;
                    unset($this->wrappedListeners[$eventName][$index]);
                    break;
                }
            }
        }

<<<<<<< HEAD
        $this->dispatcher->removeListener($eventName, $listener);
    }

    /**
     * @return void
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->removeSubscriber($subscriber);
    }

=======
        return $this->dispatcher->removeListener($eventName, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->dispatcher->removeSubscriber($subscriber);
    }

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
        // we might have wrapped listeners for the event (if called while dispatching)
        // in that case get the priority by wrapper
        if (isset($this->wrappedListeners[$eventName])) {
            foreach ($this->wrappedListeners[$eventName] as $wrappedListener) {
                if ($wrappedListener->getWrappedListener() === $listener || ($listener instanceof \Closure && $wrappedListener->getWrappedListener() == $listener)) {
                    return $this->dispatcher->getListenerPriority($eventName, $wrappedListener);
                }
            }
        }

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

<<<<<<< HEAD
    public function dispatch(object $event, string $eventName = null): object
    {
        $eventName ??= $event::class;

        $this->callStack ??= new \SplObjectStorage();
=======
    /**
     * {@inheritdoc}
     */
    public function dispatch(object $event, string $eventName = null): object
    {
        $eventName = $eventName ?? \get_class($event);

        if (null === $this->callStack) {
            $this->callStack = new \SplObjectStorage();
        }
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

        $currentRequestHash = $this->currentRequestHash = $this->requestStack && ($request = $this->requestStack->getCurrentRequest()) ? spl_object_hash($request) : '';

        if (null !== $this->logger && $event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            $this->logger->debug(sprintf('The "%s" event is already stopped. No listeners have been called.', $eventName));
        }

        $this->preProcess($eventName);
        try {
            $this->beforeDispatch($eventName, $event);
            try {
                $e = $this->stopwatch->start($eventName, 'section');
                try {
                    $this->dispatcher->dispatch($event, $eventName);
                } finally {
                    if ($e->isStarted()) {
                        $e->stop();
                    }
                }
            } finally {
                $this->afterDispatch($eventName, $event);
            }
        } finally {
            $this->currentRequestHash = $currentRequestHash;
            $this->postProcess($eventName);
        }

        return $event;
    }

    public function getCalledListeners(Request $request = null): array
    {
        if (null === $this->callStack) {
            return [];
        }

        $hash = $request ? spl_object_hash($request) : null;
        $called = [];
        foreach ($this->callStack as $listener) {
            [$eventName, $requestHash] = $this->callStack->getInfo();
            if (null === $hash || $hash === $requestHash) {
                $called[] = $listener->getInfo($eventName);
            }
        }

        return $called;
    }

    public function getNotCalledListeners(Request $request = null): array
    {
        try {
<<<<<<< HEAD
            $allListeners = $this->dispatcher instanceof EventDispatcher ? $this->getListenersWithPriority() : $this->getListenersWithoutPriority();
        } catch (\Exception $e) {
            $this->logger?->info('An exception was thrown while getting the uncalled listeners.', ['exception' => $e]);
=======
            $allListeners = $this->getListeners();
        } catch (\Exception $e) {
            if (null !== $this->logger) {
                $this->logger->info('An exception was thrown while getting the uncalled listeners.', ['exception' => $e]);
            }
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

            // unable to retrieve the uncalled listeners
            return [];
        }

        $hash = $request ? spl_object_hash($request) : null;
        $calledListeners = [];

        if (null !== $this->callStack) {
            foreach ($this->callStack as $calledListener) {
                [, $requestHash] = $this->callStack->getInfo();

                if (null === $hash || $hash === $requestHash) {
                    $calledListeners[] = $calledListener->getWrappedListener();
                }
            }
        }

        $notCalled = [];
<<<<<<< HEAD

        foreach ($allListeners as $eventName => $listeners) {
            foreach ($listeners as [$listener, $priority]) {
                if (!\in_array($listener, $calledListeners, true)) {
                    if (!$listener instanceof WrappedListener) {
                        $listener = new WrappedListener($listener, null, $this->stopwatch, $this, $priority);
=======
        foreach ($allListeners as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                if (!\in_array($listener, $calledListeners, true)) {
                    if (!$listener instanceof WrappedListener) {
                        $listener = new WrappedListener($listener, null, $this->stopwatch, $this);
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
                    }
                    $notCalled[] = $listener->getInfo($eventName);
                }
            }
        }

<<<<<<< HEAD
        uasort($notCalled, $this->sortNotCalledListeners(...));
=======
        uasort($notCalled, [$this, 'sortNotCalledListeners']);
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

        return $notCalled;
    }

    public function getOrphanedEvents(Request $request = null): array
    {
        if ($request) {
            return $this->orphanedEvents[spl_object_hash($request)] ?? [];
        }

        if (!$this->orphanedEvents) {
            return [];
        }

        return array_merge(...array_values($this->orphanedEvents));
    }

<<<<<<< HEAD
    /**
     * @return void
     */
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function reset()
    {
        $this->callStack = null;
        $this->orphanedEvents = [];
        $this->currentRequestHash = '';
    }

    /**
     * Proxies all method calls to the original event dispatcher.
     *
     * @param string $method    The method name
     * @param array  $arguments The method arguments
     */
    public function __call(string $method, array $arguments): mixed
    {
        return $this->dispatcher->{$method}(...$arguments);
    }

    /**
     * Called before dispatching the event.
<<<<<<< HEAD
     *
     * @return void
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    protected function beforeDispatch(string $eventName, object $event)
    {
    }

    /**
     * Called after dispatching the event.
<<<<<<< HEAD
     *
     * @return void
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    protected function afterDispatch(string $eventName, object $event)
    {
    }

    private function preProcess(string $eventName): void
    {
        if (!$this->dispatcher->hasListeners($eventName)) {
            $this->orphanedEvents[$this->currentRequestHash][] = $eventName;

            return;
        }

        foreach ($this->dispatcher->getListeners($eventName) as $listener) {
            $priority = $this->getListenerPriority($eventName, $listener);
            $wrappedListener = new WrappedListener($listener instanceof WrappedListener ? $listener->getWrappedListener() : $listener, null, $this->stopwatch, $this);
            $this->wrappedListeners[$eventName][] = $wrappedListener;
            $this->dispatcher->removeListener($eventName, $listener);
            $this->dispatcher->addListener($eventName, $wrappedListener, $priority);
            $this->callStack->attach($wrappedListener, [$eventName, $this->currentRequestHash]);
        }
    }

    private function postProcess(string $eventName): void
    {
        unset($this->wrappedListeners[$eventName]);
        $skipped = false;
        foreach ($this->dispatcher->getListeners($eventName) as $listener) {
            if (!$listener instanceof WrappedListener) { // #12845: a new listener was added during dispatch.
                continue;
            }
            // Unwrap listener
            $priority = $this->getListenerPriority($eventName, $listener);
            $this->dispatcher->removeListener($eventName, $listener);
            $this->dispatcher->addListener($eventName, $listener->getWrappedListener(), $priority);

            if (null !== $this->logger) {
                $context = ['event' => $eventName, 'listener' => $listener->getPretty()];
            }

            if ($listener->wasCalled()) {
<<<<<<< HEAD
                $this->logger?->debug('Notified event "{event}" to listener "{listener}".', $context);
=======
                if (null !== $this->logger) {
                    $this->logger->debug('Notified event "{event}" to listener "{listener}".', $context);
                }
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
            } else {
                $this->callStack->detach($listener);
            }

            if (null !== $this->logger && $skipped) {
                $this->logger->debug('Listener "{listener}" was not called for event "{event}".', $context);
            }

            if ($listener->stoppedPropagation()) {
<<<<<<< HEAD
                $this->logger?->debug('Listener "{listener}" stopped propagation of the event "{event}".', $context);
=======
                if (null !== $this->logger) {
                    $this->logger->debug('Listener "{listener}" stopped propagation of the event "{event}".', $context);
                }
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

                $skipped = true;
            }
        }
    }

<<<<<<< HEAD
    private function sortNotCalledListeners(array $a, array $b): int
=======
    private function sortNotCalledListeners(array $a, array $b)
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        if (0 !== $cmp = strcmp($a['event'], $b['event'])) {
            return $cmp;
        }

        if (\is_int($a['priority']) && !\is_int($b['priority'])) {
            return 1;
        }

        if (!\is_int($a['priority']) && \is_int($b['priority'])) {
            return -1;
        }

        if ($a['priority'] === $b['priority']) {
            return 0;
        }

        if ($a['priority'] > $b['priority']) {
            return -1;
        }

        return 1;
    }
<<<<<<< HEAD

    private function getListenersWithPriority(): array
    {
        $result = [];

        $allListeners = new \ReflectionProperty(EventDispatcher::class, 'listeners');
        $allListeners->setAccessible(true);

        foreach ($allListeners->getValue($this->dispatcher) as $eventName => $listenersByPriority) {
            foreach ($listenersByPriority as $priority => $listeners) {
                foreach ($listeners as $listener) {
                    $result[$eventName][] = [$listener, $priority];
                }
            }
        }

        return $result;
    }

    private function getListenersWithoutPriority(): array
    {
        $result = [];

        foreach ($this->getListeners() as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                $result[$eventName][] = [$listener, null];
            }
        }

        return $result;
    }
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
}
