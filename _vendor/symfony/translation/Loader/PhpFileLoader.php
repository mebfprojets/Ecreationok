<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Loader;

/**
 * PhpFileLoader loads translations from PHP files returning an array of translations.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class PhpFileLoader extends FileLoader
{
    private static ?array $cache = [];

<<<<<<< HEAD
    protected function loadResource(string $resource): array
    {
        if ([] === self::$cache && \function_exists('opcache_invalidate') && filter_var(\ini_get('opcache.enable'), \FILTER_VALIDATE_BOOL) && (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) || filter_var(\ini_get('opcache.enable_cli'), \FILTER_VALIDATE_BOOL))) {
=======
    /**
     * {@inheritdoc}
     */
    protected function loadResource(string $resource): array
    {
        if ([] === self::$cache && \function_exists('opcache_invalidate') && filter_var(\ini_get('opcache.enable'), \FILTER_VALIDATE_BOOLEAN) && (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) || filter_var(\ini_get('opcache.enable_cli'), \FILTER_VALIDATE_BOOLEAN))) {
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
            self::$cache = null;
        }

        if (null === self::$cache) {
            return require $resource;
        }

<<<<<<< HEAD
        return self::$cache[$resource] ??= require $resource;
=======
        if (isset(self::$cache[$resource])) {
            return self::$cache[$resource];
        }

        return self::$cache[$resource] = require $resource;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    }
}
