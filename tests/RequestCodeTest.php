<?php
namespace Fortytwo\SDK\TwoFactorAuthentication;

use Fortytwo\SDK\TwoFactorAuthentication\RequestCode;

class RequestCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateRequestCode()
    {
        // Assert
        $this->assertInstanceOf('Fortytwo\SDK\TwoFactorAuthentication\RequestCode', new RequestCode());
    }

    public function testSetClientRef()
    {
        $requestCode = new RequestCode();
        $clientRef = $requestCode->setClientRef("abcdef")->getClientRef();

        // Assert
        $this->assertEquals("abcdef", $clientRef);
    }

    public function testSetClientRefSanitize()
    {
        $requestCode = new RequestCode();
        $clientRef = $requestCode->setClientRef("abcdef£€")->getClientRef();

        // Assert
        $this->assertEquals("abcdef", $clientRef);
    }

    public function testSetPhoneNumber()
    {
        $requestCode = new RequestCode();
        $phoneNumber = $requestCode->setPhoneNumber("+33553586948")->getPhoneNumber();

        // Assert
        $this->assertEquals("+33553586948", $phoneNumber);
    }

    public function testSetPhoneNumberSpaced()
    {
        $requestCode = new RequestCode();
        $phoneNumber = $requestCode->setPhoneNumber("+33 553 586 948")->getPhoneNumber();

        // Assert
        $this->assertEquals("+33553586948", $phoneNumber);
    }

    public function testCodeLengthPreset()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(6, $requestCode->getCodeLength());
    }

    public function testCodeLengthSet()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(12, $requestCode->setCodeLength(12)->getCodeLength());
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage The code length have to be between 6 and 20 included.
     */
    public function testCodeLengthSetOutOfRangeException()
    {
        $requestCode = new RequestCode();
        $requestCode->setCodeLength(35);

        // Assert
        $this->assertEquals(
            "Exception: The code length have to be between 6 and 20 included.",
            $requestCode->setCodeLength(35)
        );
    }

    public function testCodeLengthSetOutOfRangeExceptionMessage()
    {
        $requestCode = new RequestCode();
        $this->setExpectedException('Exception');
        $requestCode->setCodeLength(35);
    }

    public function testCodeTypeSet()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals('alpha', $requestCode->setCodeType('alpha')->getCodeType());
    }

    public function testCodeTypeGetdefault()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals('numeric', $requestCode->getCodeType());
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Wrong code type "string". Accepted : numeric, alpha or alphanumeric
     */
    public function testCodeTypeSetWrongTypeException()
    {
        $requestCode = new RequestCode();
        $requestCode->setCodeType('string');
    }

    public function testCaseSensitiveSet()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(true, $requestCode->setCaseSensitive(true)->getCaseSensitive());
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Wrong case sensitive value. Only Boolean accepted.
     */
    public function testCaseSensitiveSetWrongValueException()
    {
        $requestCode = new RequestCode();
        $requestCode->setCaseSensitive('plop');
    }

    public function testCallbackUrlSet()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(
            "https://www.fortytwo.com",
            $requestCode
                ->setCallbackUrl("https://www.fortytwo.com")
                ->getCallbackUrl()
        );
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Invalid URL.
     */
    public function testCallbackUrlSetWrongFormatException()
    {
        $requestCode = new RequestCode();
        $requestCode->setCallbackUrl('fortytwo-com');
    }

    public function testSenderIdSetNumeric()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(
            "123456",
            $requestCode
                ->setSenderId("123456")
                ->getSenderId()
        );
    }

    public function testSenderIdSetAlphaNumeric()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(
            "123456abc",
            $requestCode
                ->setSenderId("123456abc")
                ->getSenderId()
        );
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage The sender ID is too long (15 Max.).
     */
    public function testSenderIdSetTooLongNumericException()
    {
        $requestCode = new RequestCode();
        $requestCode->setSenderId('123456789123456789');
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage The sender ID is too long (11 Max.).
     */
    public function testSenderIdSetTooLongAlphaNumericException()
    {
        $requestCode = new RequestCode();
        $requestCode->setSenderId('1234567891abc');
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage The sender ID is not a numeric of alphanumeric.
     */
    public function testSenderIdSetIsNotException()
    {
        $requestCode = new RequestCode();
        $requestCode->setSenderId('123456/{}7891abc');
    }

    public function testToJSON()
    {
        $requestCode = new RequestCode();

        // Assert
        $this->assertEquals(
            '{"code_length":6,"code_type":"numeric"}',
            $requestCode
                ->toJSON()
        );
    }

    public function testFullToJSON()
    {
        $requestCode = new RequestCode();

        $requestCode
            ->setClientRef('abc123456')
            ->setPhoneNumber('+35553586948')
            ->setCodeLength(10)
            ->setCodeType('alphanumeric')
            ->setCaseSensitive(true)
            ->setCallbackUrl('https://www.fortytwo.com')
            ->setSenderId('123456abc')
        ;

        // Assert
        $this->assertContains(
            'client_ref',
            $requestCode->toJSON()
        );

        $this->assertContains(
            'phone_number',
            $requestCode->toJSON()
        );

        $this->assertContains(
            'code_length',
            $requestCode->toJSON()
        );

        $this->assertContains(
            'code_type',
            $requestCode->toJSON()
        );

        $this->assertContains(
            'case_sensitive',
            $requestCode->toJSON()
        );

        $this->assertContains(
            'callback_url',
            $requestCode->toJSON()
        );

        $this->assertContains(
            'sender_id',
            $requestCode->toJSON()
        );
    }

    public function testGenericSetter()
    {
        $requestCode = new RequestCode();

        $this->assertEquals(
            '123456',
            $requestCode
                ->set('senderId', '123456')
                ->getSenderId()
        );
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage No setter for codeTypeList.
     */
    public function testGenericSetterException()
    {
        $requestCode = new RequestCode();

        $requestCode->set('codeTypeList', '123456');
    }
}
