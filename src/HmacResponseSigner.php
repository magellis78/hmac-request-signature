<?php declare(strict_types = 1);

namespace BE\HmacRequestValidation;

use Acquia\Hmac\KeyLoader;
use Acquia\Hmac\RequestAuthenticator;
use Acquia\Hmac\ResponseSigner;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HmacResponseSigner
{
    /**
     * @var string
     */
    private $keyId;

    /**
     * @var string
     */
    private $keySecret;


    public function __construct(string $keyId, string $keySecret)
    {
        $this->keyId = $keyId;
        $this->keySecret = $keySecret;
    }


    public function getSignedResponse(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $keyLoader = new KeyLoader([$this->keyId => $this->keySecret]);
        $authenticator = new RequestAuthenticator($keyLoader);

        $key = $authenticator->authenticate($request);

        $signer = new ResponseSigner($key, $request);

        return $signer->signResponse($response);
    }
}
