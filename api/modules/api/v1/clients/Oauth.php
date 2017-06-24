<?php

namespace api\modules\api\v1\clients;

use api\modules\api\v1\models\Customer;
use yii\base\Configurable;
use yii\base\InvalidValueException;
use GuzzleHttp\Client;

class Oauth implements Configurable
{
    protected $httpClient;

    protected $config;

    public function __construct(Client $client, array $config = [])
    {
        $this->httpClient = $client;
        $this->config = $config;
    }

    public function register(Customer $customer)
    {
        $oauthReponse = $this->httpClient->post($this->config['oauthEndpoint'] . '/register', [
            'allow_redirects'   => false,
            'headers'           => [
                'Accept' => 'application/json'
            ],
            'form_params'       => [
                'username' => $customer->getAttribute('email'),
                'password' => $customer->getAttribute('password'),
            ]
        ]);

        if ($oauthReponse->getStatusCode() === 201) {
            $oauthUser = json_decode($oauthReponse->getBody());
            if ($oauthUser->id) {
                return $oauthUser;
            }
        }

        throw new InvalidValueException();
    }
}
