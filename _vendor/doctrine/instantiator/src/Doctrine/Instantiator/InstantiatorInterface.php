<?php

<<<<<<< HEAD
declare(strict_types=1);

=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
namespace Doctrine\Instantiator;

use Doctrine\Instantiator\Exception\ExceptionInterface;

/**
 * Instantiator provides utility methods to build objects without invoking their constructors
 */
interface InstantiatorInterface
{
    /**
<<<<<<< HEAD
     * @phpstan-param class-string<T> $className
     *
=======
     * @param string $className
     * @phpstan-param class-string<T> $className
     *
     * @return object
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     * @phpstan-return T
     *
     * @throws ExceptionInterface
     *
     * @template T of object
     */
<<<<<<< HEAD
    public function instantiate(string $className): object;
=======
    public function instantiate($className);
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
}
