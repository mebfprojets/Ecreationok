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

namespace Ramsey\Collection\Exception;

<<<<<<< HEAD
use OutOfBoundsException as PhpOutOfBoundsException;

/**
 * Thrown when attempting to access an element out of the range of the collection.
 */
class OutOfBoundsException extends PhpOutOfBoundsException implements CollectionException
=======
/**
 * Thrown when attempting to access an element out of the range of the collection.
 */
class OutOfBoundsException extends \OutOfBoundsException
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
{
}
