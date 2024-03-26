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

use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class DataCollectorTranslator implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface, WarmableInterface
{
    public const MESSAGE_DEFINED = 0;
    public const MESSAGE_MISSING = 1;
    public const MESSAGE_EQUALS_FALLBACK = 2;

<<<<<<< HEAD
    private TranslatorInterface $translator;
=======
    private $translator;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    private array $messages = [];

    /**
     * @param TranslatorInterface&TranslatorBagInterface&LocaleAwareInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        if (!$translator instanceof TranslatorBagInterface || !$translator instanceof LocaleAwareInterface) {
            throw new InvalidArgumentException(sprintf('The Translator "%s" must implement TranslatorInterface, TranslatorBagInterface and LocaleAwareInterface.', get_debug_type($translator)));
        }

        $this->translator = $translator;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function trans(?string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        $trans = $this->translator->trans($id = (string) $id, $parameters, $domain, $locale);
        $this->collectMessage($locale, $domain, $id, $trans, $parameters);

        return $trans;
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function setLocale(string $locale)
    {
        $this->translator->setLocale($locale);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getLocale(): string
    {
        return $this->translator->getLocale();
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getCatalogue(string $locale = null): MessageCatalogueInterface
    {
        return $this->translator->getCatalogue($locale);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getCatalogues(): array
    {
        return $this->translator->getCatalogues();
    }

    /**
<<<<<<< HEAD
=======
     * {@inheritdoc}
     *
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     * @return string[]
     */
    public function warmUp(string $cacheDir): array
    {
        if ($this->translator instanceof WarmableInterface) {
            return (array) $this->translator->warmUp($cacheDir);
        }

        return [];
    }

    /**
     * Gets the fallback locales.
     */
    public function getFallbackLocales(): array
    {
        if ($this->translator instanceof Translator || method_exists($this->translator, 'getFallbackLocales')) {
            return $this->translator->getFallbackLocales();
        }

        return [];
    }

    /**
     * Passes through all unknown calls onto the translator object.
     */
    public function __call(string $method, array $args)
    {
        return $this->translator->{$method}(...$args);
    }

    public function getCollectedMessages(): array
    {
        return $this->messages;
    }

<<<<<<< HEAD
    private function collectMessage(?string $locale, ?string $domain, string $id, string $translation, ?array $parameters = []): void
    {
        $domain ??= 'messages';
=======
    private function collectMessage(?string $locale, ?string $domain, string $id, string $translation, ?array $parameters = [])
    {
        if (null === $domain) {
            $domain = 'messages';
        }
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85

        $catalogue = $this->translator->getCatalogue($locale);
        $locale = $catalogue->getLocale();
        $fallbackLocale = null;
        if ($catalogue->defines($id, $domain)) {
            $state = self::MESSAGE_DEFINED;
        } elseif ($catalogue->has($id, $domain)) {
            $state = self::MESSAGE_EQUALS_FALLBACK;

            $fallbackCatalogue = $catalogue->getFallbackCatalogue();
            while ($fallbackCatalogue) {
                if ($fallbackCatalogue->defines($id, $domain)) {
                    $fallbackLocale = $fallbackCatalogue->getLocale();
                    break;
                }
                $fallbackCatalogue = $fallbackCatalogue->getFallbackCatalogue();
            }
        } else {
            $state = self::MESSAGE_MISSING;
        }

        $this->messages[] = [
            'locale' => $locale,
            'fallbackLocale' => $fallbackLocale,
            'domain' => $domain,
            'id' => $id,
            'translation' => $translation,
            'parameters' => $parameters,
            'state' => $state,
            'transChoiceNumber' => isset($parameters['%count%']) && is_numeric($parameters['%count%']) ? $parameters['%count%'] : null,
        ];
    }
}
