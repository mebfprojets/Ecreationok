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
use Ramsey\Collection\Tool\TypeTrait;
use Ramsey\Collection\Tool\ValueToStringTrait;

<<<<<<< HEAD
use function array_key_first;

=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
/**
 * This class provides a basic implementation of `QueueInterface`, to minimize
 * the effort required to implement this interface.
 *
 * @template T
 * @extends AbstractArray<T>
 * @implements QueueInterface<T>
 */
class Queue extends AbstractArray implements QueueInterface
{
    use TypeTrait;
    use ValueToStringTrait;

    /**
<<<<<<< HEAD
     * Constructs a queue object of the specified type, optionally with the
     * specified data.
     *
     * @param string $queueType The type or class name associated with this queue.
     * @param array<array-key, T> $data The initial items to store in the queue.
     */
    public function __construct(private readonly string $queueType, array $data = [])
    {
=======
     * The type of elements stored in this queue.
     *
     * A queue's type is immutable once it is set. For this reason, this
     * property is set private.
     */
    private string $queueType;

    /**
     * The index of the head of the queue.
     */
    protected int $index = 0;

    /**
     * Constructs a queue object of the specified type, optionally with the
     * specified data.
     *
     * @param string $queueType The type (FQCN) associated with this queue.
     * @param array<array-key, T> $data The initial items to store in the collection.
     */
    public function __construct(string $queueType, array $data = [])
    {
        $this->queueType = $queueType;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
        parent::__construct($data);
    }

    /**
     * {@inheritDoc}
     *
     * Since arbitrary offsets may not be manipulated in a queue, this method
     * serves only to fulfill the `ArrayAccess` interface requirements. It is
     * invoked by other operations when adding values to the queue.
     *
<<<<<<< HEAD
     * @throws InvalidArgumentException if $value is of the wrong type.
     */
    public function offsetSet(mixed $offset, mixed $value): void
=======
     * @throws InvalidArgumentException if $value is of the wrong type
     */
    public function offsetSet($offset, $value): void
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        if ($this->checkType($this->getType(), $value) === false) {
            throw new InvalidArgumentException(
                'Value must be of type ' . $this->getType() . '; value is '
                . $this->toolValueToString($value),
            );
        }

        $this->data[] = $value;
    }

    /**
<<<<<<< HEAD
     * @throws InvalidArgumentException if $value is of the wrong type.
     */
    public function add(mixed $element): bool
=======
     * @throws InvalidArgumentException if $value is of the wrong type
     *
     * @inheritDoc
     */
    public function add($element): bool
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        $this[] = $element;

        return true;
    }

    /**
<<<<<<< HEAD
     * @return T
     *
     * @throws NoSuchElementException if this queue is empty.
     */
    public function element(): mixed
    {
        return $this->peek() ?? throw new NoSuchElementException(
            'Can\'t return element from Queue. Queue is empty.',
        );
    }

    public function offer(mixed $element): bool
    {
        try {
            return $this->add($element);
        } catch (InvalidArgumentException) {
=======
     * @inheritDoc
     */
    public function element()
    {
        $element = $this->peek();

        if ($element === null) {
            throw new NoSuchElementException(
                'Can\'t return element from Queue. Queue is empty.',
            );
        }

        return $element;
    }

    /**
     * @inheritDoc
     */
    public function offer($element): bool
    {
        try {
            return $this->add($element);
        } catch (InvalidArgumentException $e) {
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
            return false;
        }
    }

    /**
<<<<<<< HEAD
     * @return T | null
     */
    public function peek(): mixed
    {
        $index = array_key_first($this->data);

        if ($index === null) {
            return null;
        }

        return $this[$index];
    }

    /**
     * @return T | null
     */
    public function poll(): mixed
    {
        $index = array_key_first($this->data);

        if ($index === null) {
            return null;
        }

        $head = $this[$index];
        unset($this[$index]);
=======
     * @inheritDoc
     */
    public function peek()
    {
        if ($this->count() === 0) {
            return null;
        }

        return $this[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function poll()
    {
        if ($this->count() === 0) {
            return null;
        }

        $head = $this[$this->index];

        unset($this[$this->index]);
        $this->index++;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

        return $head;
    }

    /**
<<<<<<< HEAD
     * @return T
     *
     * @throws NoSuchElementException if this queue is empty.
     */
    public function remove(): mixed
    {
        return $this->poll() ?? throw new NoSuchElementException(
            'Can\'t return element from Queue. Queue is empty.',
        );
=======
     * @inheritDoc
     */
    public function remove()
    {
        $head = $this->poll();

        if ($head === null) {
            throw new NoSuchElementException('Can\'t return element from Queue. Queue is empty.');
        }

        return $head;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    }

    public function getType(): string
    {
        return $this->queueType;
    }
}
