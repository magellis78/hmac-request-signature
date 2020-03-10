<?php declare(strict_types = 1);

namespace BrandEmbassy\HmacRequestSignature;

final class Headers
{
    public const SIGNATURE_HEADER = 'X-Request-Signature';
    public const SIGNATURE_ALGORITHM_HEADER = 'X-Signature-Algorithm';
}
