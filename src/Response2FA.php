<?php
namespace fortytwo\TwoFactorAuthentication;

// Import JMS Serializer
use JMS\Serializer\Annotation\Type;
// Import the HTTP client
use Buzz\Message\Response;
// Import SKD related
use fortytwo\TwoFactorAuthentication\ResponseResultInfo;
use fortytwo\TwoFactorAuthentication\ResponseResult;

/**
 * Response object used to store/manipulate data fron the response of a "request code" .
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class Response2FA
{
    /**
     * @Type("string")
     */
    private $apiJobId;
    /**
     * @Type("fortytwo\TwoFactorAuthentication\ResponseResultInfo")
     */
    private $resultInfo;

    /**
     * @Type("fortytwo\TwoFactorAuthentication\ResponseResult")
     */
    private $result;


    public function __construct()
    {
        $this->resultInfo = new ResponseResultInfo();
        $this->result = new ResponseResult();
    }

    public function getApiJobId()
    {
        return $this->apiJobId;
    }

    public function setApiJobID($value)
    {
        $this->apiJobId = $value;

        return $this;
    }

    public function getResultInfo()
    {
        return $this->resultInfo;
    }

    public function getResult()
    {
        return $this->result;
    }
}
