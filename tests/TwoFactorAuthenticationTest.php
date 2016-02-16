<?php
namespace fortytwo\TwoFactorAuthentication;

use fortytwo\TwoFactorAuthentication\TwoFactorAuthentication;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class TwoFactorAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateTwoFactorAuthentication()
    {
        // Assert
        $this->assertInstanceOf(
            'fortytwo\TwoFactorAuthentication\TwoFactorAuthentication',
            new TwoFactorAuthentication('mySuperToken')
        );
    }

    public function testRequestCode()
    {
        $mock = new MockHandler([
            new Response(
                201,
                [],
                '{
                  "api_job_id": "0c6ccf37-dd15-49ff-a12f-ffad8f2655a6",
                  "result_info": {
                    "status_code": 0,
                    "description": "Success"
                  },
                  "result": {
                    "message_id": "14466445287300014003"
                  }
                }'
            )
        ]);
        $handler = HandlerStack::create($mock);

        $requestCode =  new TwoFactorAuthentication('0ac6f722-9792-4b6e-993f-757a2583c7fb', $handler);
        $response = $requestCode->requestCode(
            '123456789',
            '35699982808',
            array(
                'codeLength'    => 10,
                'codeType'      => 'alphanumeric'
            )
        );

        $this->assertEquals('0c6ccf37-dd15-49ff-a12f-ffad8f2655a6', $response->getApiJobId());
        $this->assertEquals('0', $response->getResultInfo()->getStatusCode());
        $this->assertEquals('14466445287300014003', $response->getResult()->getMessageId());
    }

    public function testValidateCode()
    {
        $mock = new MockHandler([
            new Response(
                200,
                [],
                '{
                  "api_job_id": "0c6ccf37-dd15-49ff-a12f-ffad8f2655a6",
                  "result_info": {
                    "status_code": 0,
                    "description": "Valid"
                  }
                }'
            )
        ]);
        $handler = HandlerStack::create($mock);

        $validateCode = new TwoFactorAuthentication('0ac6f722-9792-4b6e-993f-757a2583c7fb', $handler);
        $response = $validateCode->validateCode('reference1', '123456');

        $this->assertEquals('0', $response->getResultInfo()->getStatusCode());
    }
}
