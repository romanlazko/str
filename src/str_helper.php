<?php

use RomanLazko\Str\Str;
use Stringable;

if (! function_exists('str')) {
    /**
     * Get a new stringable object from the given string.
     *
     * @param  string|null  $string
     * @return object
     */
    function str($string = null)
    {
        return new class($string) implements Stringable
        {
            public function __construct(public string $string)
            {
            }

            public function __call($method, $parameters): self
            {
                $this->string = Str::$method($this->string, ...$parameters);

                return $this;
            }

            public function toString(): string
            {
                return $this->string;
            }

            public function __toString(): string
            {
                return $this->toString();
            }
        };
    }
}