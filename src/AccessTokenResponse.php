<?php

namespace Killov\AppleSignIn;

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Psr\Http\Message\ResponseInterface;

class AccessTokenResponse {

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct($response) {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface {
        return $this->response;
    }

    /**
     * @return mixed
     */
    private function getBodyJson() {
        return json_decode($this->response->getBody()->getContents());
    }

    /**
     * @return string
     */
    public function getIdTokenString(): string {
        $json = $this->getBodyJson();
        return $json->id_token;
    }

}