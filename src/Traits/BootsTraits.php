<?php

namespace AxeBear\Magic\Traits;

use ReflectionClass;

/**
 * Calls a "bootClassName" method on each trait used by the class.
 */
trait BootsTraits
{
    public function __construct(...$args)
    {
        if (get_parent_class($this)) {
            parent::__construct(...$args);
        }

        $this->bootTraits();
        $this->traitsBooted();
    }

    /**
     * Provides a hook for initializing the class after the constructor has run.
     */
    protected function traitsBooted(): void
    {
        // noop
    }

    /**
     * Boots any traits that include a bootClassName method.
     */
    protected function bootTraits(): void
    {
        $traits = $this->traits();
        foreach ($traits as $trait) {
            $reflection = new ReflectionClass($trait);
            $shortName = $reflection->getShortName();
            $booter = 'boot'.$shortName;
            if ($reflection->hasMethod($booter)) {
                $this->$booter();
            }
        }
    }

    /**
     * Gets a list of traits used by the class or its parents.
     */
    public function traits(): array
    {
        $class = static::class;
        $traits = [];
        do {
            $traits = [...$traits, ...class_uses($class)];
        } while ($class = get_parent_class($class));

        return $traits;
    }
}
