<?php

namespace Fortytwo\SDK\TwoFactorAuthentication;

use Fortytwo\SDK\TwoFactorAuthentication\RequestCode;
use Fortytwo\SDK\TwoFactorAuthentication\ReponseRequestCode;
use JMS\Serializer\SerializerBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * TwoFactorAuthentication Main class for the library.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TwoFactorAuthentication
{
    private $client;
    const API_URL = 'https://rest.fortytwo.com/1/';
    const API_2FA_RESSOURCE = '2fa';

    /**
     * CONTSTRUCTOR - Initalize the Request object and define the headers
     *
     * @api
     * @param $token client token for authentication
     * @param $handler for testing purposes
     */
    public function __construct($token, $handler = false)
    {
        $client = [
            'headers' => [
                'User-Agent' => 'Fortytwo SDK - 2FA - 1.0.0',
                'Content-Type'     => 'application/json; charset=utf-8',
                'Authorization'      => 'Token ' . $token
            ],
        ];

        if ($handler) {
            $client['handler'] =  $handler;
        }

        $this->client = new Client($client);
    }

    /**
     * Request the authentication code
     *
     * @api
     * @param $clientRef string Client reference
     * @param $phoneNumber string Destination Phone number
     * @param $optionaArgs array List of optionals arguments
     *
     * @return Response Object
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

        $response = $this->client->request(
            'POST',
            self::API_URL.self::API_2FA_RESSOURCE,
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
     * @return Response Object
     */
    public function validateCode($clientRef, $code)
    {
        $response = $this->client->request(
            'POST',
            self::API_URL .
            self::API_2FA_RESSOURCE . '/' .
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
