<?php

namespace Fortytwo\SDK\TwoFactorAuthentication;

use Fortytwo\SDK\Core\Core;
use Fortytwo\SDK\TwoFactorAuthentication\RequestCode;
use JMS\Serializer\SerializerBuilder;

/**
 * TwoFactorAuthentication Main class for the library.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TwoFactorAuthentication extends Core
{
    /**
     * Request the authentication code
     *
     * @api
     * @param string $clientRef     Client reference
     * @param string $phoneNumber   Destination Phone number
     * @param array  $optionalArgs   List of optionals arguments
     *
     * @return object response
     */
    public function requestCode($clientRef, $phoneNumber, $optionalArgs = array())
    {
        $requestCode = new RequestCode;
        $requestCode
            ->setClientRef($clientRef)
            ->setPhoneNumber($phoneNumber);

        if (count($optionalArgs) > 0) {
            foreach ($optionalArgs as $key => $value) {
                $requestCode->set($key, $value);
            }
        }

        $response = $this->request('TFA/Request', array(), $requestCode);

        $serializer = SerializerBuilder::create()->build();
        $result = $serializer->deserialize(
            $response,
            'Fortytwo\SDK\TwoFactorAuthentication\Response2FA',
            'json'
        );
        return $result;
    }

    /**
     * Validate authentication with the code
     *
     * @api
     * @param string $clientRef Client reference
     * @param string $code      Code to validate
     *
     * @return object Response
     */
    public function validateCode($clientRef, $code)
    {
        $response = $this->request('TFA/Validate', array($clientRef, $code));

        $serializer = SerializerBuilder::create()->build();
        $result = $serializer->deserialize(
            $response,
            'Fortytwo\SDK\TwoFactorAuthentication\Response2FA',
            'json'
        );
        return $result;
    }
}
