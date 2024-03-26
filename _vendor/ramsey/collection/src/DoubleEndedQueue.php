<?php

/**
 * This file is part of the ramsey/collection library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ramsey\Collection;

use Ramsey\Collection\Exception\InvalidArgumentException;
use Ramsey\Collection\Exception\NoSuchElementException;

<<<<<<< HEAD
use function array_key_last;
use function array_pop;
use function array_unshift;

=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
/**
 * This class provides a basic implementation of `DoubleEndedQueueInterface`, to
 * minimize the effort required to implement this interface.
 *
 * @template T
 * @extends Queue<T>
 * @implements DoubleEndedQueueInterface<T>
 */
class DoubleEndedQueue extends Queue implements DoubleEndedQueueInterface
{
    /**
<<<<<<< HEAD
     * Constructs a double-ended queue (dequeue) object of the specified type,
     * optionally with the specified data.
     *
     * @param string $queueType The type or class name associated with this dequeue.
     * @param array<array-key, T> $data The initial items to store in the dequeue.
     */
    public function __construct(private readonly string $queueType, array $data = [])
    {
        parent::__construct($this->queueType, $data);
=======
     * Index of the last element in the queue.
     */
    private int $tail = -1;

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($this->checkType($this->getType(), $value) === false) {
            throw new InvalidArgumentException(
                'Value must be of type ' . $this->getType() . '; value is '
                . $this->toolValueToString($value),
            );
        }

        $this->tail++;

        $this->data[$this->tail] = $value;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    }

    /**
     * @throws InvalidArgumentException if $element is of the wrong type
<<<<<<< HEAD
     */
    public function addFirst(mixed $element): bool
=======
     *
     * @inheritDoc
     */
    public function addFirst($element): bool
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        if ($this->checkType($this->getType(), $element) === false) {
            throw new InvalidArgumentException(
                'Value must be of type ' . $this->getType() . '; value is '
                . $this->toolValueToString($element),
            );
        }

<<<<<<< HEAD
        array_unshift($this->data, $element);
=======
        $this->index--;

        $this->data[$this->index] = $element;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

        return true;
    }

    /**
<<<<<<< HEAD
     * @throws InvalidArgumentException if $element is of the wrong type
     */
    public function addLast(mixed $element): bool
=======
     * @inheritDoc
     */
    public function addLast($element): bool
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        return $this->add($element);
    }

<<<<<<< HEAD
    public function offerFirst(mixed $element): bool
    {
        try {
            return $this->addFirst($element);
        } catch (InvalidArgumentException) {
=======
    /**
     * @inheritDoc
     */
    public function offerFirst($element): bool
    {
        try {
            return $this->addFirst($element);
        } catch (InvalidArgumentException $e) {
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
            return false;
        }
    }

<<<<<<< HEAD
    public function offerLast(mixed $element): bool
=======
    /**
     * @inheritDoc
     */
    public function offerLast($element): bool
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        return $this->offer($element);
    }

    /**
<<<<<<< HEAD
     * @return T the first element in this queue.
     *
     * @throws NoSuchElementException if the queue is empty
     */
    public function removeFirst(): mixed
=======
     * @inheritDoc
     */
    public function removeFirst()
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        return $this->remove();
    }

    /**
<<<<<<< HEAD
     * @return T the last element in this queue.
     *
     * @throws NoSuchElementException if this queue is empty.
     */
    public function removeLast(): mixed
    {
        return $this->pollLast() ?? throw new NoSuchElementException(
            'Can\'t return element from Queue. Queue is empty.',
        );
    }

    /**
     * @return T | null the head of this queue, or `null` if this queue is empty.
     */
    public function pollFirst(): mixed
=======
     * @inheritDoc
     */
    public function removeLast()
    {
        $tail = $this->pollLast();

        if ($tail === null) {
            throw new NoSuchElementException('Can\'t return element from Queue. Queue is empty.');
        }

        return $tail;
    }

    /**
     * @inheritDoc
     */
    public function pollFirst()
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        return $this->poll();
    }

    /**
<<<<<<< HEAD
     * @return T | null the tail of this queue, or `null` if this queue is empty.
     */
    public function pollLast(): mixed
    {
        return array_pop($this->data);
    }

    /**
     * @return T the head of this queue.
     *
     * @throws NoSuchElementException if this queue is empty.
     */
    public function firstElement(): mixed
=======
     * @inheritDoc
     */
    public function pollLast()
    {
        if ($this->count() === 0) {
            return null;
        }

        $tail = $this[$this->tail];

        unset($this[$this->tail]);
        $this->tail--;

        return $tail;
    }

    /**
     * @inheritDoc
     */
    public function firstElement()
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        return $this->element();
    }

    /**
<<<<<<< HEAD
     * @return T the tail of this queue.
     *
     * @throws NoSuchElementException if this queue is empty.
     */
    public function lastElement(): mixed
    {
        return $this->peekLast() ?? throw new NoSuchElementException(
            'Can\'t return element from Queue. Queue is empty.',
        );
    }

    /**
     * @return T | null the head of this queue, or `null` if this queue is empty.
     */
    public function peekFirst(): mixed
=======
     * @inheritDoc
     */
    public function lastElement()
    {
        if ($this->count() === 0) {
            throw new NoSuchElementException('Can\'t return element from Queue. Queue is empty.');
        }

        return $this->data[$this->tail];
    }

    /**
     * @inheritDoc
     */
    public function peekFirst()
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        return $this->peek();
    }

    /**
<<<<<<< HEAD
     * @return T | null the tail of this queue, or `null` if this queue is empty.
     */
    public function peekLast(): mixed
    {
        $lastIndex = array_key_last($this->data);

        if ($lastIndex === null) {
            return null;
        }

        return $this->data[$lastIndex];
=======
     * @inheritDoc
     */
    public function peekLast()
    {
        if ($this->count() === 0) {
            return null;
        }

        return $this->data[$this->tail];
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    }
}
