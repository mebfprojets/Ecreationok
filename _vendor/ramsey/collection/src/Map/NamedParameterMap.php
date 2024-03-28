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

namespace Ramsey\Collection\Map;

use Ramsey\Collection\Exception\InvalidArgumentException;
use Ramsey\Collection\Tool\TypeTrait;
use Ramsey\Collection\Tool\ValueToStringTrait;

use function array_combine;
use function array_key_exists;
use function is_int;
<<<<<<< HEAD
=======
use function var_export;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

/**
 * `NamedParameterMap` represents a mapping of values to a set of named keys
 * that may optionally be typed
 *
<<<<<<< HEAD
 * @extends AbstractMap<string, mixed>
=======
 * @extends AbstractMap<mixed>
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
 */
class NamedParameterMap extends AbstractMap
{
    use TypeTrait;
    use ValueToStringTrait;

    /**
     * Named parameters defined for this map.
     *
     * @var array<string, string>
     */
<<<<<<< HEAD
    private readonly array $namedParameters;
=======
    protected array $namedParameters;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

    /**
     * Constructs a new `NamedParameterMap`.
     *
     * @param array<array-key, string> $namedParameters The named parameters defined for this map.
<<<<<<< HEAD
     * @param array<string, mixed> $data An initial set of data to set on this map.
=======
     * @param array<array-key, mixed> $data An initial set of data to set on this map.
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function __construct(array $namedParameters, array $data = [])
    {
        $this->namedParameters = $this->filterNamedParameters($namedParameters);
        parent::__construct($data);
    }

    /**
     * Returns named parameters set for this `NamedParameterMap`.
     *
     * @return array<string, string>
     */
    public function getNamedParameters(): array
    {
        return $this->namedParameters;
    }

<<<<<<< HEAD
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!array_key_exists($offset, $this->namedParameters)) {
            throw new InvalidArgumentException(
                'Attempting to set value for unconfigured parameter \''
                . $this->toolValueToString($offset) . '\'',
=======
    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            throw new InvalidArgumentException(
                'Map elements are key/value pairs; a key must be provided for '
                . 'value ' . var_export($value, true),
            );
        }

        if (!array_key_exists($offset, $this->namedParameters)) {
            throw new InvalidArgumentException(
                'Attempting to set value for unconfigured parameter \''
                . $offset . '\'',
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
            );
        }

        if ($this->checkType($this->namedParameters[$offset], $value) === false) {
            throw new InvalidArgumentException(
                'Value for \'' . $offset . '\' must be of type '
                . $this->namedParameters[$offset] . '; value is '
                . $this->toolValueToString($value),
            );
        }

        $this->data[$offset] = $value;
    }

    /**
     * Given an array of named parameters, constructs a proper mapping of
     * named parameters to types.
     *
     * @param array<array-key, string> $namedParameters The named parameters to filter.
     *
     * @return array<string, string>
     */
    protected function filterNamedParameters(array $namedParameters): array
    {
        $names = [];
        $types = [];

        foreach ($namedParameters as $key => $value) {
            if (is_int($key)) {
                $names[] = $value;
                $types[] = 'mixed';
            } else {
                $names[] = $key;
                $types[] = $value;
            }
        }

        return array_combine($names, $types) ?: [];
    }
}