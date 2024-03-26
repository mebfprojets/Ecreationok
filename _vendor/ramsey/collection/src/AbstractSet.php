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

/**
 * This class contains the basic implementation of a collection that does not
 * allow duplicated values (a set), to minimize the effort required to implement
 * this specific type of collection.
 *
 * @template T
 * @extends AbstractCollection<T>
 */
abstract class AbstractSet extends AbstractCollection
{
<<<<<<< HEAD
    public function add(mixed $element): bool
=======
    /**
     * @inheritDoc
     */
    public function add($element): bool
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        if ($this->contains($element)) {
            return false;
        }

        return parent::add($element);
    }

<<<<<<< HEAD
    public function offsetSet(mixed $offset, mixed $value): void
=======
    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        if ($this->contains($value)) {
            return;
        }

        parent::offsetSet($offset, $value);
    }
}
