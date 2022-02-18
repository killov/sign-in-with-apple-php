<?php

namespace Killov\AppleSignIn;

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
        $payload = [
            'iat' => time(),
            'exp' => time() + 360,
            'iss' => $this->teamId,
            'aud' => 'https://appleid.apple.com',
            'sub' => $this->clientId
        ];

        $key = file_get_contents($this->keyPath);

        return JWT::encode($payload, $key, 'ES256', $this->keyId);
    }
}