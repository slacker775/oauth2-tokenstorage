<?php
namespace OAuth\Client\TokenStorage;

use League\OAuth2\Client\Token\AccessTokenInterface;
use OAuth\Client\Exception\TokenNotFoundException;
use League\OAuth2\Client\Token\AccessToken;

class File implements TokenStorageInterface
{

    /**
     *
     * @var string
     */
    protected $filePath = null;

    public function __construct(string $path = '.')
    {
        $this->filePath = $path;
    }

    private function getTokenFilename(string $id): string
    {
        $filename = sprintf("%s%s%s.token", $this->filePath, DIRECTORY_SEPARATOR, $id);
        return $filename;
    }

    public function loadToken(string $name): AccessTokenInterface
    {
        $filename = $this->getTokenFilename($name);
        if (file_exists($filename) === true) {
            $accessToken = new AccessToken(json_decode(file_get_contents($filename), true));
            return $accessToken;
        }
        throw new TokenNotFoundException($filename . ' not found');
    }

    public function storeToken(AccessTokenInterface $token, string $name): void
    {
        $filename = $this->getTokenFilename($name);
        file_put_contents($filename, json_encode($token));
    }

    public function hasToken(string $name): bool
    {
        $filename = $this->getTokenFilename($name);
        return file_exists($filename);
    }

}