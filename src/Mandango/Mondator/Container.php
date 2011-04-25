<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator;

/**
 * Container of definitions.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Container implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private $definitions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->definitions = array();
    }

    /**
     * Returns if a definition name exists.
     *
     * @param string $name The definition name.
     *
     * @return bool Returns if the definition name exists.
     */
    public function hasDefinition($name)
    {
        return isset($this->definitions[$name]);
    }

    /**
     * Set a definition.
     *
     * @param string                       $name       The definition name.
     * @param Mandango\Mondator\Definition $definition The definition.
     */
    public function setDefinition($name, Definition $definition)
    {
        $this->definitions[$name] = $definition;
    }

    /**
     * Set the definitions.
     *
     * @param array $definitions An array of definitions.
     */
    public function setDefinitions(array $definitions)
    {
        $this->definitions = array();
        foreach ($definitions as $name => $definition) {
            $this->setDefinition($name, $definition);
        }
    }

    /**
     * Returns a definition by name.
     *
     * @param string $name The definition name.
     *
     * @return Mandango\Mondator\Definition The definition.
     *
     * @throws \InvalidArgumentException If the definition does not exists.
     */
    public function getDefinition($name)
    {
        if (!$this->hasDefinition($name)) {
            throw new \InvalidArgumentException(sprintf('The definition "%s" does not exists.', $name));
        }

        return $this->definitions[$name];
    }

    /**
     * Returns the definitions.
     *
     * @return arary The definitions.
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Remove a definition
     *
     * @param string $name The definition name
     *
     * @throws \InvalidArgumentException If the definition does not exists.
     */
    public function removeDefinition($name)
    {
        if (!$this->hasDefinition($name)) {
            throw new \InvalidArgumentException(sprintf('The definition "%s" does not exists.', $name));
        }

        unset($this->definitions[$name]);
    }

    /**
     * Clear the definitions.
     */
    public function clearDefinitions()
    {
        $this->definitions = array();
    }

    /*
     * \ArrayAccess interface.
     */
    public function offsetExists($name)
    {
        return $this->hasDefinition($name);
    }

    public function offsetSet($name, $definition)
    {
        $this->setDefinition($name, $definition);
    }

    public function offsetGet($name)
    {
        return $this->getDefinition($name);
    }

    public function offsetUnset($name)
    {
        $this->removeDefinition($name);
    }

    /**
     * Returns the number of definitions (implements the \Countable interface).
     *
     * @return integer The number of definitions.
     */
    public function count()
    {
        return count($this->definitions);
    }

    /**
     * Returns an \ArrayIterator with the definitions (implements \IteratorAggregate interface).
     *
     * @return \ArrayIterator An \ArrayIterator with the definitions.
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->definitions);
    }
}
