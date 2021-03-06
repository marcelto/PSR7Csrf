<?php

declare(strict_types=1);

namespace PSR7CsrfTest\Exception;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Csrf\Exception\ExceptionInterface;
use PSR7Csrf\Exception\SessionAttributeNotFoundException;
use UnexpectedValueException;

/**
 * @covers \PSR7Csrf\Exception\SessionAttributeNotFoundException
 */
final class SessionAttributeNotFoundExceptionTest extends TestCase
{
    public function testFromInvalidExpirationTime()
    {
        /* @var $request ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject */
        $request = $this->createMock(ServerRequestInterface::class);

        $request->expects(self::any())->method('getAttributes')->willReturn(['foo' => 'bar', 'baz' => 'tab']);

        $exception = SessionAttributeNotFoundException::fromAttributeNameAndRequest('foo', $request);

        self::assertInstanceOf(SessionAttributeNotFoundException::class, $exception);
        self::assertInstanceOf(UnexpectedValueException::class, $exception);
        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertSame(
            'Provided request contains no matching session attribute "foo", attributes ["foo","baz"] exist',
            $exception->getMessage()
        );
    }
}
