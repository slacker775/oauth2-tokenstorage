<?php

namespace OAuth\Client\TokenStorage;

use League\OAuth2\Client\Token\AccessTokenInterface;

interface TokenStorageInterface
{

    public function storeToken(AccessTokenInterface $token, string $name): void;

    public function loadToken(string $name): ?AccessTokenInterface;

    public function hasToken(string $name): bool;
}