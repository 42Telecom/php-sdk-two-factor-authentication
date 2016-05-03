<?php

namespace Fortytwo\SDK\TwoFactorAuthentication;

use Fortytwo\SDK\Core\Core;
use Fortytwo\SDK\Core\Factories\ServiceFactory;
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
     * @param $clientRef string Client reference
     * @param $phoneNumber string Destination Phone number
     * @param $optionaArgs array List of optionals arguments
     *
     * @return object response
     */
    public function requestCode($clientRef, $phoneNumber, $optionalArgs = array())
    {
        $api = ServiceFactory::get('TFA/Request');

        $requestCode = new RequestCode;
        $requestCode
            ->setClientRef($clientRef)
            ->setPhoneNumber($phoneNumber);

        if (count($optionalArgs) > 0) {
            foreach ($optionalArgs as $key => $value) {
                $requestCode->set($key, $value);
            }
        }

        $response = $this->client->request(
            $api->getMethod(),
            $api->getEndPoint(),
            [
                'body' => $requestCode->toJSON()
            ]
        );

        $serializer = SerializerBuilder::create()->build();
        $result = $serializer->deserialize(
            $response->getBody(),
            'Fortytwo\SDK\TwoFactorAuthentication\Response2FA',
            'json'
        );
        return $result;
    }

    /**
     * Validate authentication with the code
     *
     * @api
     * @param $clientRef string Client reference
     * @param $code string Code to validate
     *
     * @return object Response
     */
    public function validateCode($clientRef, $code)
    {
        $api = ServiceFactory::get('TFA/Validate');

        $response = $this->client->request(
            $api->getMethod(),
            $api->getEndPoint() . '/' .
            filter_var($clientRef, FILTER_SANITIZE_URL). '/' .
            filter_var($code, FILTER_SANITIZE_URL)
        );

        $serializer = SerializerBuilder::create()->build();
        $result = $serializer->deserialize(
            $response->getBody(),
            'Fortytwo\SDK\TwoFactorAuthentication\Response2FA',
            'json'
        );
        return $result;
    }
}
