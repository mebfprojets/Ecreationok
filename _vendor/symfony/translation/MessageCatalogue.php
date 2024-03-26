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

use Symfony\Component\Config\Resource\ResourceInterface;
use Symfony\Component\Translation\Exception\LogicException;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class MessageCatalogue implements MessageCatalogueInterface, MetadataAwareInterface, CatalogueMetadataAwareInterface
{
    private array $messages = [];
    private array $metadata = [];
    private array $catalogueMetadata = [];
    private array $resources = [];
    private string $locale;
    private ?MessageCatalogueInterface $fallbackCatalogue = null;
=======
class MessageCatalogue implements MessageCatalogueInterface, MetadataAwareInterface
{
    private array $messages = [];
    private array $metadata = [];
    private array $resources = [];
    private string $locale;
    private $fallbackCatalogue = null;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    private ?self $parent = null;

    /**
     * @param array $messages An array of messages classified by domain
     */
    public function __construct(string $locale, array $messages = [])
    {
        $this->locale = $locale;
        $this->messages = $messages;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getLocale(): string
    {
        return $this->locale;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getDomains(): array
    {
        $domains = [];

        foreach ($this->messages as $domain => $messages) {
            if (str_ends_with($domain, self::INTL_DOMAIN_SUFFIX)) {
                $domain = substr($domain, 0, -\strlen(self::INTL_DOMAIN_SUFFIX));
            }
            $domains[$domain] = $domain;
        }

        return array_values($domains);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function all(string $domain = null): array
    {
        if (null !== $domain) {
            // skip messages merge if intl-icu requested explicitly
            if (str_ends_with($domain, self::INTL_DOMAIN_SUFFIX)) {
                return $this->messages[$domain] ?? [];
            }

            return ($this->messages[$domain.self::INTL_DOMAIN_SUFFIX] ?? []) + ($this->messages[$domain] ?? []);
        }

        $allMessages = [];

        foreach ($this->messages as $domain => $messages) {
            if (str_ends_with($domain, self::INTL_DOMAIN_SUFFIX)) {
                $domain = substr($domain, 0, -\strlen(self::INTL_DOMAIN_SUFFIX));
                $allMessages[$domain] = $messages + ($allMessages[$domain] ?? []);
            } else {
                $allMessages[$domain] = ($allMessages[$domain] ?? []) + $messages;
            }
        }

        return $allMessages;
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function set(string $id, string $translation, string $domain = 'messages')
    {
        $this->add([$id => $translation], $domain);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function has(string $id, string $domain = 'messages'): bool
    {
        if (isset($this->messages[$domain][$id]) || isset($this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id])) {
            return true;
        }

        if (null !== $this->fallbackCatalogue) {
            return $this->fallbackCatalogue->has($id, $domain);
        }

        return false;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function defines(string $id, string $domain = 'messages'): bool
    {
        return isset($this->messages[$domain][$id]) || isset($this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id]);
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function get(string $id, string $domain = 'messages'): string
    {
        if (isset($this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id])) {
            return $this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id];
        }

        if (isset($this->messages[$domain][$id])) {
            return $this->messages[$domain][$id];
        }

        if (null !== $this->fallbackCatalogue) {
            return $this->fallbackCatalogue->get($id, $domain);
        }

        return $id;
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function replace(array $messages, string $domain = 'messages')
    {
        unset($this->messages[$domain], $this->messages[$domain.self::INTL_DOMAIN_SUFFIX]);

        $this->add($messages, $domain);
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function add(array $messages, string $domain = 'messages')
    {
        $altDomain = str_ends_with($domain, self::INTL_DOMAIN_SUFFIX) ? substr($domain, 0, -\strlen(self::INTL_DOMAIN_SUFFIX)) : $domain.self::INTL_DOMAIN_SUFFIX;
        foreach ($messages as $id => $message) {
            unset($this->messages[$altDomain][$id]);
            $this->messages[$domain][$id] = $message;
        }

        if ([] === ($this->messages[$altDomain] ?? null)) {
            unset($this->messages[$altDomain]);
        }
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addCatalogue(MessageCatalogueInterface $catalogue)
    {
        if ($catalogue->getLocale() !== $this->locale) {
            throw new LogicException(sprintf('Cannot add a catalogue for locale "%s" as the current locale for this catalogue is "%s".', $catalogue->getLocale(), $this->locale));
        }

        foreach ($catalogue->all() as $domain => $messages) {
            if ($intlMessages = $catalogue->all($domain.self::INTL_DOMAIN_SUFFIX)) {
                $this->add($intlMessages, $domain.self::INTL_DOMAIN_SUFFIX);
                $messages = array_diff_key($messages, $intlMessages);
            }
            $this->add($messages, $domain);
        }

        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }

        if ($catalogue instanceof MetadataAwareInterface) {
            $metadata = $catalogue->getMetadata('', '');
            $this->addMetadata($metadata);
        }
<<<<<<< HEAD

        if ($catalogue instanceof CatalogueMetadataAwareInterface) {
            $catalogueMetadata = $catalogue->getCatalogueMetadata('', '');
            $this->addCatalogueMetadata($catalogueMetadata);
        }
    }

    /**
     * @return void
=======
    }

    /**
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addFallbackCatalogue(MessageCatalogueInterface $catalogue)
    {
        // detect circular references
        $c = $catalogue;
        while ($c = $c->getFallbackCatalogue()) {
            if ($c->getLocale() === $this->getLocale()) {
                throw new LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".', $catalogue->getLocale()));
            }
        }

        $c = $this;
        do {
            if ($c->getLocale() === $catalogue->getLocale()) {
                throw new LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".', $catalogue->getLocale()));
            }

            foreach ($catalogue->getResources() as $resource) {
                $c->addResource($resource);
            }
        } while ($c = $c->parent);

        $catalogue->parent = $this;
        $this->fallbackCatalogue = $catalogue;

        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getFallbackCatalogue(): ?MessageCatalogueInterface
    {
        return $this->fallbackCatalogue;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getResources(): array
    {
        return array_values($this->resources);
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[$resource->__toString()] = $resource;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    public function getMetadata(string $key = '', string $domain = 'messages'): mixed
    {
        if ('' == $domain) {
            return $this->metadata;
        }

        if (isset($this->metadata[$domain])) {
            if ('' == $key) {
                return $this->metadata[$domain];
            }

            if (isset($this->metadata[$domain][$key])) {
                return $this->metadata[$domain][$key];
            }
        }

        return null;
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function setMetadata(string $key, mixed $value, string $domain = 'messages')
    {
        $this->metadata[$domain][$key] = $value;
    }

    /**
<<<<<<< HEAD
     * @return void
=======
     * {@inheritdoc}
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
     */
    public function deleteMetadata(string $key = '', string $domain = 'messages')
    {
        if ('' == $domain) {
            $this->metadata = [];
        } elseif ('' == $key) {
            unset($this->metadata[$domain]);
        } else {
            unset($this->metadata[$domain][$key]);
        }
    }

<<<<<<< HEAD
    public function getCatalogueMetadata(string $key = '', string $domain = 'messages'): mixed
    {
        if (!$domain) {
            return $this->catalogueMetadata;
        }

        if (isset($this->catalogueMetadata[$domain])) {
            if (!$key) {
                return $this->catalogueMetadata[$domain];
            }

            if (isset($this->catalogueMetadata[$domain][$key])) {
                return $this->catalogueMetadata[$domain][$key];
            }
        }

        return null;
    }

    /**
     * @return void
     */
    public function setCatalogueMetadata(string $key, mixed $value, string $domain = 'messages')
    {
        $this->catalogueMetadata[$domain][$key] = $value;
    }

    /**
     * @return void
     */
    public function deleteCatalogueMetadata(string $key = '', string $domain = 'messages')
    {
        if (!$domain) {
            $this->catalogueMetadata = [];
        } elseif (!$key) {
            unset($this->catalogueMetadata[$domain]);
        } else {
            unset($this->catalogueMetadata[$domain][$key]);
        }
    }

=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    /**
     * Adds current values with the new values.
     *
     * @param array $values Values to add
     */
<<<<<<< HEAD
    private function addMetadata(array $values): void
=======
    private function addMetadata(array $values)
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    {
        foreach ($values as $domain => $keys) {
            foreach ($keys as $key => $value) {
                $this->setMetadata($key, $value, $domain);
            }
        }
    }
<<<<<<< HEAD

    private function addCatalogueMetadata(array $values): void
    {
        foreach ($values as $domain => $keys) {
            foreach ($keys as $key => $value) {
                $this->setCatalogueMetadata($key, $value, $domain);
            }
        }
    }
=======
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
}
