<?php declare(strict_types = 1);

namespace BE\HmacRequestValidation;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use Acquia\Hmac\KeyInterface;
use Closure;

class HmacRequestSignerMiddleware
{
    /**
     * @var string
     */
    private $realm;

    /**
     * @var KeyInterface|null
     */
    private $key;

    /**
     * @var string[][]
     */
    private $customHeaders;


    /**
     * @param string[][] $customHeaders
     */
    public function init(string $keyId, string $keySecret, string $realm, array $customHeaders = []): void
    {
        $this->key = new Key($keyId, $keySecret);
        $this->realm = $realm;
        $this->customHeaders = $customHeaders;
    }


    public function __invoke(callable $handler): Closure
    {
        if ($this->key === null) {
            return function ($request, array $options) use ($handler) {
                return $handler($request, $options);
            };
        }

        $hmacAuthMiddleware = new HmacAuthMiddleware($this->key, $this->realm, $this->customHeaders);

        return $hmacAuthMiddleware($handler);
    }
}
