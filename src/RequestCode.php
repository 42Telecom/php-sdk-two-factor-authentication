<?php
namespace Fortytwo\SDK\TwoFactorAuthentication;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Request object used to store/manipulate/validate the data of the 'request code' .
 *
 * @ExclusionPolicy("all")
 * @license https://opensource.org/licenses/MIT MIT
 */
class RequestCode
{
    // Define default values for the code length.
    const CODE_LENGTH_DEFAULT           = 6;
    const CODE_LENGTH_MAX               = 20;
    // Define possible values for the code type.
    const CODE_TYPE_NUMERIC             = 'numeric';
    const CODE_TYPE_ALPHA               = 'alpha';
    const CODE_TYPE_ALPHANUMERIC        = 'alphanumeric';
    // Define send id limitations
    const SENDER_ID_NUMERIC_MAX         = 15;
    const SENDER_ID_ALPHANUMERIC_MAX    = 11;

    // define internals variables
    /**
     * @Expose
     */
    private $clientRef      = null;
    /**
     * @Expose
     */
    private $phoneNumber    = null;
    /**
     * @Expose
     */
    private $codeLength     = self::CODE_LENGTH_DEFAULT;
    /**
     * @Expose
     */
    private $codeType       = self::CODE_TYPE_NUMERIC;
    /**
     * @Expose
     */
    private $caseSensitive  = null;
    /**
     * @Expose
     */
    private $callbackUrl    = null;
    /**
     * @Expose
     */
    private $senderId       = null;

    private $codeTypeList   = array(
        self::CODE_TYPE_NUMERIC,
        self::CODE_TYPE_ALPHA,
        self::CODE_TYPE_ALPHANUMERIC
    );

    /**
     * Get the current client reference
     *
     * @return string current client reference
     */
    public function getClientRef()
    {
        return $this->clientRef;
    }

    /**
     * Set the client reference
     *
     * @param string $value client reference
     * @return the current instance
     */
    public function setClientRef($value)
    {
        $this->clientRef = filter_var($value, FILTER_SANITIZE_URL);
        return $this;
    }

    /**
     * Get the current phone number
     *
     * @return string current phone number
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the phone number
     *
     * @param string $value phone number
     * @return the current instance
     */
    public function setPhoneNumber($value)
    {
        $this->phoneNumber = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        return $this;
    }

    /**
     * Get the current code length
     *
     * @return string current code length
     */
    public function getCodeLength()
    {
        return $this->codeLength;
    }

    /**
     * Set the code length
     *
     * @param integer $value between 6 and 20
     * @throws Exception if the code length is not between the default and max lenght defined.
     * @return the current instance
     */
    public function setCodeLength($value)
    {
        $this->codeLength = filter_var(
            $value,
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'min_range' => self::CODE_LENGTH_DEFAULT,
                    'max_range' => self::CODE_LENGTH_MAX
                )
            )
        );

        if (!$this->codeLength) {
            throw new \Exception('The code length have to be between 6 and 20 included.');
        }

        return $this;
    }

    /**
     * Get the current code type
     *
     * @return string current code type
     */
    public function getCodeType()
    {
        return $this->codeType;
    }

    /**
     * Set the code type (default numeric)
     *
     * @param string $value code type (numeric,alpha or alphanumeric)
     * @throws Exception if the parameter is not in the options available
     * @return the current instance
     */
    public function setCodeType($value)
    {
        if (in_array($value, $this->codeTypeList)) {
            $this->codeType = $value;
        } else {
            throw new \Exception('Wrong code type "' . $value . '". Accepted : numeric, alpha or alphanumeric');
        }

        return $this;
    }

    /**
     * Get the current case sensitive value
     *
     * @return boolean case sensitive value
     */
    public function getCaseSensitive()
    {
        return $this->caseSensitive;
    }

    /**
     * Set the case sensitive option
     *
     * @param boolean $value true or false.
     * @throws Exception if the passed parameter is not a boolean
     * @return the current instance
     */
    public function setCaseSensitive($value)
    {

        if (is_bool($value)) {
            $this->caseSensitive = $value;
        } else {
            throw new \Exception('Wrong case sensitive value. Only Boolean accepted.');
        }

        return $this;
    }

    /**
     * Get the callback URL
     *
     * @return string Callback url
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * Set the Callback URL
     *
     * @param string $value Callback url
     * @throws Exception if the URL is not valid.
     * @return the current instance
     */
    public function setCallbackUrl($value)
    {
        $this->callbackUrl = filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);

        if (!$this->callbackUrl) {
            throw new \Exception('Invalid URL.');
        }

        return $this;
    }

    /**
     * Get the current sender ID.
     *
     * @return string sender ID
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Set the sender ID
     *
     * @param string $value Sender ID
     * @throws Exception if the senderid is to long or is not an numeric/alphanumeric
     * @return the current instance
     */
    public function setSenderId($value)
    {
        if (is_numeric($value)) {
            if (strlen($value) <= self::SENDER_ID_NUMERIC_MAX) {
                $this->senderId = $value;
            } else {
                throw new \Exception('The sender ID is too long (' . self::SENDER_ID_NUMERIC_MAX . ' Max.).');
            }
        } elseif (ctype_alnum($value)) {
            if (strlen($value) <= self::SENDER_ID_ALPHANUMERIC_MAX) {
                $this->senderId = $value;
            } else {
                throw new \Exception('The sender ID is too long (' . self::SENDER_ID_ALPHANUMERIC_MAX . ' Max.).');
            }
        } else {
            throw new \Exception('The sender ID is not a numeric of alphanumeric.');
        }
        return $this;
    }

    /**
     * Convert the current object to JSON format.
     *
     * @return JSON serialized object
     */
    public function toJSON()
    {
        $serializer = SerializerBuilder::create()->build();

        return $serializer->serialize($this, 'json');
    }

    /**
     * Set the available variables in the object
     *
     * @param Variable $variableName name to set
     * @param Variable $value value to set
     * @throws Exception if the variable name is not authorized
     * @return the current instance
     */
    public function set($variableName, $value)
    {
        $authorizedSetters = array(
            'clientRef',
            'phoneNumber',
            'codeLength',
            'codeType',
            'caseSensitive',
            'callbackUrl',
            'senderId'
        );

        if (in_array($variableName, $authorizedSetters)) {
            $name = 'set' . ucfirst($variableName);
            $this->$name($value);
        } else {
            throw new \Exception('No setter for ' . $variableName . '.');
        }

        return $this;
    }
}
