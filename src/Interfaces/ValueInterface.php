<?php

namespace Fortytwo\SDK\TwoFactorAuthentication\Interfaces;

/**
 * Value object interface.
 *
 * @ExclusionPolicy("all")
 * @license https://opensource.org/licenses/MIT MIT
 */
interface ValueInterface
{
    /**
     * Constructor used to set the value of the object.
     *
     * @param mixed $value Value for the object.
     * @throws \Exception invalid value.
     */
    public function __construct($value);

    /**
     * toString used for returning the value of the object.
     */
    public function __toString();
}
