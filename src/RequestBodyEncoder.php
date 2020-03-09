<?php declare(strict_types = 1);

namespace BrandEmbassy\HmacRequestValidator;

use Psr\Http\Message\RequestInterface;
use function base64_encode;
use function hash_hmac;

final class RequestBodyEncoder
{
    public static function encode(RequestInterface $request, string $secretKey, string $hashAlgorithm): string
    {
        $requestBody = (string)$request->getBody();

        $digest = hash_hmac($hashAlgorithm, $requestBody, $secretKey, true);

        return base64_encode($digest);
    }
}
