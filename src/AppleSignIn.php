<?php

namespace Killov\AppleSignIn;

class AppleSignIn {

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var JwtCreator
     */
    private $jwtCreator;


    /**
     * @param string $clientId
     * @param string $redirectUrl
     * @param JwtCreator $jwtCreator
     */
    public function __construct($clientId, $redirectUrl, $jwtCreator) {
        $this->clientId = $clientId;
        $this->redirectUrl = $redirectUrl;
        $this->jwtCreator = $jwtCreator;
    }

    /**
     * @param string $state
     * @return string
     */
    public function createAuthUrl($state) {
        return 'https://appleid.apple.com/auth/authorize'.'?'.http_build_query([
            'response_type' => 'code',
            'response_mode' => 'form_post',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'state' => $state,
            'scope' => 'name email',
        ]);
    }

    /**
     * @param $code
     * @return AccessTokenResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchAccessTokenWithAuthCode($code) {
        $client = new \GuzzleHttp\Client();
        $options = [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUrl,
                'client_id' => $this->clientId,
                'client_secret' => $this->jwtCreator->create(),
            ]
        ];
        $response = $client->post("https://appleid.apple.com/auth/token", $options);

        return new AccessTokenResponse($response);
    }
}