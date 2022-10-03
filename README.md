# PSR-15 demonstration using Zend Expressive (Laminas)
- https://www.youtube.com/watch?v=uS3yKQt9hG0

This repository is POC of using the PSR-15 framework to implement a web service that tracks information about issues that need to be fixed (Zendesk).

## Top things

### Request body validation

I wanted to make the process of parsing body request to be smoother and cleaner in request handler implementation. I decided that in handler I want to receive a valid value object, which represents the body of the incoming request. Each request body is represented by an object implementing the abstract class `AbstractValidRequest` and provides data constraints for fields using the `symfony/validator` package. When we create a new instance of that class we know that incoming data have valid structure and types, when they are not valid, the exception is fired and caught in middleware, then transformed into an error response.


### Request handlers tests

There is a small detail on how to write E2E tests of the application. In test cases, I can create a new instance of the whole Expressive application and programmatically create the incoming request, and then directly check the response without network layer. The support layer is hidden in [EndpointTestCase](https://github.com/jankaderabek/expressive-playground/blob/master/test/AppTest/Integration/Support/Endpoint/EndpointTestCase.php)

## Tech stack
- PHP 7.1
- Zend/Expressive (Laminas in these days)
- symfony/validator
- Laravel collections (tightenco/collect)
