<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

/**
 * Allows providing hooks on domain-specific lifecycles by dispatching events.
 */
interface EventDispatcherInterface extends PsrEventDispatcherInterface
{
    /**
     * Dispatches an event to all registered listeners.
     *
<<<<<<< HEAD
     * @template T of object
     *
     * @param T           $event     The event to pass to the event handlers/listeners
     * @param string|null $eventName The name of the event to dispatch. If not supplied,
     *                               the class of $event should be used instead.
     *
     * @return T The passed $event MUST be returned
=======
     * @param object      $event     The event to pass to the event handlers/listeners
     * @param string|null $eventName The name of the event to dispatch. If not supplied,
     *                               the class of $event should be used instead.
     *
     * @return object The passed $event MUST be returned
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function dispatch(object $event, string $eventName = null): object;
}
