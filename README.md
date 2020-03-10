# HMAC Request Signature

This small library will allow you to sign http reuqests for future verification. This is typically used as optional security in webhook consuming apps

## Installation 

`composer require brandembassy/hmac-request-signature`

## Usage

Signed requests contains HTTP headers 
`X-Request-Signature`: Signature itself (base64)
`X-Signature-Algorithm`: Algorithm used to calc signature (default: sha256)

### How to sign your requests

You need to use `RequestSignerMiddleware` in guzzle client handlers stack, you can use `SignedRequestsClientFactory::create('{{yourSecretKey}}')`. 
This middleware will calc signature from request payload and secret key and provide it in request header `X-Request-Signature`.

### How to validate request signature

Just use `SignedRequestValidator::validateSignature` where exception is thrown in case signature validation failed
