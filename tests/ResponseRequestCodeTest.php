<?php
namespace fortytwo\TwoFactorAuthentication;

use fortytwo\TwoFactorAuthentication\Response2FA;

class Response2FATest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateResponse2FA()
    {
        // Assert
        $this->assertInstanceOf('fortytwo\TwoFactorAuthentication\Response2FA', new Response2FA());
    }


    public function testApiJobId()
    {
        $response = new Response2FA();
        // Assert
        $this->assertEquals(
            "0c6ccf37-dd15-49ff-a12f-ffad8f2655a6",
            $response
                ->setApiJobID('0c6ccf37-dd15-49ff-a12f-ffad8f2655a6')
                ->getApiJobId()
        );
    }
}
