<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Nate Wiebe <nate@northern.co>
 */
class TranslatableMessage implements TranslatableInterface
{
    private string $message;
    private array $parameters;
    private ?string $domain;

    public function __construct(string $message, array $parameters = [], string $domain = null)
    {
        $this->message = $message;
        $this->parameters = $parameters;
        $this->domain = $domain;
    }

    public function __toString(): string
    {
        return $this->getMessage();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function trans(TranslatorInterface $translator, string $locale = null): string
    {
        return $translator->trans($this->getMessage(), array_map(
<<<<<<< HEAD
            static fn ($parameter) => $parameter instanceof TranslatableInterface ? $parameter->trans($translator, $locale) : $parameter,
=======
            static function ($parameter) use ($translator, $locale) {
                return $parameter instanceof TranslatableInterface ? $parameter->trans($translator, $locale) : $parameter;
            },
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
            $this->getParameters()
        ), $this->getDomain(), $locale);
    }
}
