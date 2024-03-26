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
use InvalidArgumentException as PhpInvalidArgumentException;

/**
 * Thrown to indicate an argument is not of the expected type.
 */
class InvalidArgumentException extends PhpInvalidArgumentException implements CollectionException
=======
/**
 * Thrown to indicate an argument is not of the expected type.
 */
class InvalidArgumentException extends \InvalidArgumentException
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
{
}
