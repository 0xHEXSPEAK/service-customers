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
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token(),
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

    public function token()
    {
        $oauthResponse = $this->httpClient->post($this->config['oauthEndpoint'] . '/token', [
            'form_params'       => [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->config['oauthClientId'],
                'client_secret' => $this->config['oauthClientSecret']
            ],
        ]);

        if ($oauthResponse->getStatusCode() === 200) {
            return json_decode($oauthResponse->getBody())->access_token;
        }

        throw new InvalidValueException();
    }
}
