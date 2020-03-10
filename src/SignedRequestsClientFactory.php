<?php declare(strict_types = 1);

namespace BrandEmbassy\HmacRequestSignature;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use function array_merge;

class SignedRequestsClientFactory
{
    private const MIDDLEWARE_NAME = 'requestSigner';


    /**
     * @param mixed[] $config
     */
    public function create(string $secretKey, array $config = []): ClientInterface
    {
        $requestSignerMiddleware = new RequestSignerMiddleware($secretKey);

        $stack = HandlerStack::create();
        $stack->push($requestSignerMiddleware, self::MIDDLEWARE_NAME);

        $mergedConfig = array_merge($config, ['handler' => $stack]);

        return new Client($mergedConfig);
    }
}
