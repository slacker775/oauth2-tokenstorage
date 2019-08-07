<?php
declare(strict_types = 1);

namespace OAuth\Client\TokenStorage;

use League\Flysystem\FilesystemInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;
use League\OAuth2\Client\Token\AccessToken;

class FlySystem implements TokenStorageInterface
{

    /**
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    public function __construct(FilesystemInterface $defaultStorage)
    {
        $this->filesystem = $defaultStorage;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\OAuth\Client\TokenStorage\TokenStorageInterface::hasToken()
     */
    public function hasToken(string $name): bool
    {
        return $this->filesystem->has($name);
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\OAuth\Client\TokenStorage\TokenStorageInterface::loadToken()
     */
    public function loadToken(string $name): ?AccessTokenInterface
    {
        if ($this->hasToken($name)) {
            $token = $this->filesystem->read($name);
            return new AccessToken(json_decode($token, true));
        }
        return null;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\OAuth\Client\TokenStorage\TokenStorageInterface::storeToken()
     */
    public function storeToken(AccessTokenInterface $token, string $name): void
    {
        if ($this->hasToken($name) === true) {
            $this->filesystem->delete($name);
        }
        $this->filesystem->write($name, json_encode($token));
    }
}
