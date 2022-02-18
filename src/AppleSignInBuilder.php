<?php

namespace Killov\AppleSignIn;

class AppleSignInBuilder {

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $redirectUrl;

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

    private function __construct() { }

    /**
     * @return AppleSignInBuilder
     */
    public static function create() {
        return new self();
    }

    /**
     * @return JwtCreator
     */
    private function buildJwtCreator() {
        return new JwtCreator($this->clientId, $this->teamId, $this->keyPath, $this->keyId);
    }

    /**
     * @return AppleSignIn
     */
    public function build() {
        return new AppleSignIn($this->clientId, $this->redirectUrl, $this->buildJwtCreator());
    }

    /**
     * @param string $clientId
     * @return AppleSignInBuilder
     */
    public function setClientId(string $clientId): AppleSignInBuilder {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param string $redirectUrl
     * @return AppleSignInBuilder
     */
    public function setRedirectUrl(string $redirectUrl): AppleSignInBuilder {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * @param string $teamId
     * @return AppleSignInBuilder
     */
    public function setTeamId(string $teamId): AppleSignInBuilder {
        $this->teamId = $teamId;
        return $this;
    }

    /**
     * @param string $keyId
     * @param string $keyPath
     * @return AppleSignInBuilder
     */
    public function setKeyPath(string $keyId, string $keyPath): AppleSignInBuilder {
        $this->keyId = $keyId;
        $this->keyPath = $keyPath;
        return $this;
    }
}