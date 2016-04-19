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
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $tempValue;

    /**
     * @var string
     */
    private $regex = "/^([a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*)$/";

    /**
     * @inheritDoc
     */
    public function __construct($value)
    {
        $this->tempValue = $value;

        $this
            ->sanitize()
            ->validate();

        $this->token = $this->tempValue;

    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->token;
    }

    /**
     * Sanitize the value.
     *
     * @return $this the current instance
     */
    private function sanitize()
    {
        $this->tempValue = trim($this->tempValue);

        return $this;
    }

    /**
     * Validate the value.
     *
     * @return $this the current instance
     */
    private function validate()
    {
        if (!preg_match($this->regex, $this->tempValue)) {
            throw new \Exception('Invalid Token.');
        }

        return $this;
    }
}
