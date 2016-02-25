<?php
namespace Fortytwo\SDK\TwoFactorAuthentication;

use Fortytwo\SDK\TwoFactorAuthentication\ResponseResult;

class ResponseResultTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateResponseResult()
    {
        // Assert
        $this->assertInstanceOf('Fortytwo\SDK\TwoFactorAuthentication\ResponseResult', new ResponseResult());
    }

    public function testStatusCode()
    {
        $responseResult = new ResponseResultInfo();
        // Assert
        $this->assertEquals(
            "-65",
            $responseResult
                ->setStatusCode('-65')
                ->getStatusCode()
        );
    }

    public function testDescription()
    {
        $responseResult = new ResponseResultInfo();
        // Assert
        $this->assertEquals(
            "Success",
            $responseResult
                ->setDescription('Success')
                ->getDescription()
        );
    }
}
