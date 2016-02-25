<?php
namespace Fortytwo\SDK\TwoFactorAuthentication;

use Fortytwo\SDK\TwoFactorAuthentication\ResponseResultInfo;

class ResponseResultInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateResponseResultInfo()
    {
        // Assert
        $this->assertInstanceOf('Fortytwo\SDK\TwoFactorAuthentication\ResponseResultInfo', new ResponseResultInfo());
    }

    public function testMessageId()
    {
        $responseResult = new ResponseResult();
        // Assert
        $this->assertEquals(
            "14466445287300014003",
            $responseResult
                ->setMessageId('14466445287300014003')
                ->getMessageId()
        );
    }
}
