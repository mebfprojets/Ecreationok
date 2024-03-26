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

use ArrayAccess;
use Countable;
use IteratorAggregate;
<<<<<<< HEAD
=======
use Serializable;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

/**
 * `ArrayInterface` provides traversable array functionality to data types.
 *
 * @template T
 * @extends ArrayAccess<array-key, T>
 * @extends IteratorAggregate<array-key, T>
 */
interface ArrayInterface extends
    ArrayAccess,
    Countable,
<<<<<<< HEAD
    IteratorAggregate
=======
    IteratorAggregate,
    Serializable
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
{
    /**
     * Removes all items from this array.
     */
    public function clear(): void;

    /**
     * Returns a native PHP array representation of this array object.
     *
     * @return array<array-key, T>
     */
    public function toArray(): array;

    /**
     * Returns `true` if this array is empty.
     */
    public function isEmpty(): bool;
}
