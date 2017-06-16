<?php
use App\Auth\AuthService;
use App\Auth\Entity\User;
use App\Auth\Middleware\RoleMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RoleMiddlewareTest extends TestCase {

    public function setUp()
    {
        $this->user = new User();
        $this->user->roles = ['admin', 'demo'];
        parent::setUp();
    }

    public function fakeRequest (): RequestInterface {
        $uri = \Slim\Http\Uri::createFromString('http://fake');
        $header = new \Slim\Http\Headers();
        $body = $this->getMockBuilder(\Psr\Http\Message\StreamInterface::class)->getMock();
        return new \Slim\Http\Request('GET', $uri, $header, [], [], $body);
    }

    public function getMiddleware (string $role): RoleMiddleware {
        $auth = $this->getMockBuilder(AuthService::class)
            ->disableOriginalConstructor()
            ->setMethods(['user'])
            ->getMock();

        $auth->method('user')->willReturn($this->user);

        return new RoleMiddleware($auth, $role);
    }

    public function testFakeRole () {
        $this->user->roles = ['notAdmin'];
        $this->expectException(\App\Auth\Exception\ForbiddenException::class);
        $calls = 0;
        $this
            ->getMiddleware('admin')
            ->__invoke(
                $this->fakeRequest(),
                new \Slim\Http\Response(),
                function ($request, $response) use (&$calls) {
                    $calls++;
                    return $response;
                }
            );
        $this->assertEquals(0, $calls, 'La réponse ne doit pas être passé au reste de l\'app');
    }

    public function testGoodRole () {
        $this->user->roles = ['admin'];
        $calls = 0;
        $this
            ->getMiddleware('admin')
            ->__invoke(
                $this->fakeRequest(),
                new \Slim\Http\Response(),
                function ($request, $response) use (&$calls) {
                    $calls++;
                    return $response;
                }
            );
        $this->assertEquals(1, $calls, 'La réponse doit être passé au reste de l\'app');
    }

}