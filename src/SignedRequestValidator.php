<?php declare(strict_types = 1);

namespace BrandEmbassy\HmacRequestSignature;

use Psr\Http\Message\RequestInterface;

final class SignedRequestValidator
{
    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var string
     */
    private $signatureHeader;

    /**
     * @var string
     */
    private $signatureAlgorithmHeader;


    public function __construct(
        string $secretKey,
        string $signatureHeader = Headers::SIGNATURE_HEADER,
        string $signatureAlgorithmHeader = Headers::SIGNATURE_ALGORITHM_HEADER
    ) {
        $this->secretKey = $secretKey;
        $this->signatureHeader = $signatureHeader;
        $this->signatureAlgorithmHeader = $signatureAlgorithmHeader;
    }


    public function validateSignature(RequestInterface $request): void
    {
        $requestSignature = $request->getHeaderLine($this->signatureHeader);

        if ($requestSignature === '') {
            throw SignatureVerificationException::fromMissingSignatureHeader($this->signatureHeader);
        }

        $signatureAlgorithm = $request->getHeaderLine($this->signatureAlgorithmHeader);

        if ($signatureAlgorithm === '') {
            throw SignatureVerificationException::fromMissingHashAlgorithmHeader($this->signatureAlgorithmHeader);
        }

        $expectedRequestSignature = RequestBodyEncoder::encode($request, $this->secretKey, $signatureAlgorithm);

        if ($expectedRequestSignature !== $requestSignature) {
            throw SignatureVerificationException::fromSignatureNotMatch();
        }
    }
}
