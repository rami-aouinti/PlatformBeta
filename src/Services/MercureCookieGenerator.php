<?php

namespace App\Services;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key;

class MercureCookieGenerator
{
    const MERCURE_AUTHORIZATION_HEADER = 'mercureAuthorization';

    /**
     * @var string
     */
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function generate(): string
    {
        $key = Key\InMemory::plainText($this->secret);
        $configuration = Configuration::forSymmetricSigner(new Sha256(), $key);

        $token = $configuration->builder()
            ->withClaim('mercure', ['subscribe' => ["http://localhost/group/users"]]) // can also be a URI template, or *
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();

        return sprintf('%s=%s; path=hub/; httponly;', self::MERCURE_AUTHORIZATION_HEADER, $token);
    }
}
