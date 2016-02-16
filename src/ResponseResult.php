<?php
namespace fortytwo\TwoFactorAuthentication;

// Import JMS Serializer
use JMS\Serializer\Annotation\Type;

/**
 * ResponseResult object .
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class ResponseResult
{
    /**
     * @Type("string")
     */
    private $messageId;

    /**
     * Getter for the Message Id.
     *
     * @return  String message Id.
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Setter for the Message Id.
     *
     * @param  string $value Message Id to set.
     * @return  ResponseResult object.
     */
    public function setMessageId($value)
    {
        $this->messageId = $value;

        return $this;
    }
}
