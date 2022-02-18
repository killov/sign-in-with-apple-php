<?php

namespace Killov\AppleSignIn;

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class JwtCreator {

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $teamId;

    /**
     * @var string
     */
    private $keyPath;

    /**
     * @var string
     */
    private $keyId;

    /**
     * @param string $clientId
     * @param string $teamId
     * @param string $keyPath
     * @param string $keyId
     */
    public function __construct($clientId, $teamId, $keyPath, $keyId) {
        $this->clientId = $clientId;
        $this->teamId = $teamId;
        $this->keyPath = $keyPath;
        $this->keyId = $keyId;
    }

    /**
     * @return string
     */
    public function create() {
        $algorithmManager = new AlgorithmManager([new ES256()]);
        $jwsBuilder = new JWSBuilder($algorithmManager);

        $jws = $jwsBuilder
            ->create()
            ->withPayload(json_encode([
                'iat' => time(),
                'exp' => time() + 360,
                'iss' => $this->teamId,
                'aud' => 'https://appleid.apple.com',
                'sub' => $this->clientId
            ]))
            ->addSignature(JWKFactory::createFromKeyFile($this->keyPath), [
                'alg' => 'ES256',
                'kid' => $this->keyId
            ])
            ->build();

        $serializer = new CompactSerializer();

        return $serializer->serialize($jws, 0);
    }
}