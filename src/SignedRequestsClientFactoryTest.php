<?php declare(strict_types = 1);

namespace BrandEmbassy\HmacRequestSignature;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function assert;

final class SignedRequestsClientFactoryTest extends TestCase
{
    public function testSignerIsInHandlerStack(): void
    {
        $clientFactory = new SignedRequestsClientFactory();

        $client = $clientFactory->create('foo', [RequestOptions::TIMEOUT => 10]);

        Assert::assertSame(10, $client->getConfig(RequestOptions::TIMEOUT));

        $handler = $client->getConfig('handler');
        assert($handler instanceof HandlerStack);

        Assert::assertStringContainsString('requestSigner', (string)$handler);
    }
}
