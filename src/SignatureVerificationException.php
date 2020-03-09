<?php declare(strict_types = 1);

namespace BrandEmbassy\HmacRequestValidator;

use Exception;
use function sprintf;

final class SignatureVerificationException extends Exception
{
    public static function fromMissingSignatureHeader(string $headerName): self
    {
        return new self(sprintf('Request is missing signature header %s', $headerName));
    }


    public static function fromMissingHashAlgorithmHeader(string $headerName): self
    {
        return new self(sprintf('Request is missing hash algorithm header %s', $headerName));
    }


    public static function fromSignatureNotMatch(): self
    {
        return new self('Request signature verification failed');
    }
}
