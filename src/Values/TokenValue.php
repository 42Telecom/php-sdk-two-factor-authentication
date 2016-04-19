<?php
namespace Fortytwo\SDK\TwoFactorAuthentication\Values;

use Fortytwo\SDK\TwoFactorAuthentication\Interfaces\ValueInterface;

/**
 * Token Value object
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TokenValue implements ValueInterface
{
    private $token;

    private $tempValue;

    private $regex = "/^([a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*)$/";

    public function __construct($value)
    {
        $this->tempValue = $value;

        $this
            ->sanitize()
            ->validate();

        $this->token = $this->tempValue;

    }

    public function __toString()
    {
        return $this->token;
    }

    private function sanitize()
    {
        $this->tempValue = trim($this->tempValue);

        return $this;
    }

    private function validate()
    {
        if (!preg_match($this->regex, $this->tempValue)) {
            throw new \Exception('Invalid Token.');
        }

        return $this;
    }
}
