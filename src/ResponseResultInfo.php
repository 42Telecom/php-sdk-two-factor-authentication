<?php
namespace Fortytwo\SDK\TwoFactorAuthentication;

// Import JMS Serializer
use JMS\Serializer\Annotation\Type;

/**
 * ResponseResultInfo.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class ResponseResultInfo
{
    /**
     * @Type("integer")
     */
    private $statusCode;
    /**
     * @Type("string")
     */
    private $description;

    /**
     * Getter for the status code.
     *
     * @return string Status code.
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for the status code.
     *
     * @param  string $value Status Code to set.
     * @return  ResponseResultInfo object.
     */
    public function setStatusCode($value)
    {
        $this->statusCode = $value;

        return $this;
    }

    /**
     * Getter for the description.
     *
     * @return string Description.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Setter for the description.
     *
     * @param  string $value Description to set.
     * @return  ResponseResultInfo object.
     */
    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }
}
