<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Translation;

interface LocaleAwareInterface
{
    /**
     * Sets the current locale.
     *
<<<<<<< HEAD
     * @return void
     *
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    public function setLocale(string $locale);

    /**
     * Returns the current locale.
     */
    public function getLocale(): string;
}
