<?php

use App\Auth\Table\UserTable;

class FakePDO extends PDO
{
    public function __construct()
    {
    }
}
class AuthServiceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Core\Session\Session
     */
    private $session;

    protected function setUp()
    {
        $this->session = new Core\Session\Session();
        parent::setUp();
    }

    protected function tearDown()
    {
        $this->session->destroy();
        parent::tearDown();
    }

    public function getMockedTable()
    {
        return $this->getMockBuilder(UserTable::class)
            ->setMethods(['find', 'findByUsername'])
            ->setConstructorArgs([new FakePDO()])
            ->getMock();
    }

    public function getAuth($table)
    {
        return new \App\Auth\AuthService($table, $this->session);
    }

    public function testLoginWithBadParams()
    {
        $this->expectException(\Core\Exception\ValidationException::class);
        $table = $this->getMockedTable();
        $table->expects($this->never())
            ->method('findByUsername');
        $this->getAuth($table)->login(['username' => 'a', 'password' => 'a']);
    }

    public function testLoginWithGoodParams()
    {
        $this->expectException(\Core\Exception\ValidationException::class);
        $table = $this->getMockedTable();
        $table->expects($this->once())
            ->method('findByUsername');
        $this->getAuth($table)->login(['username' => 'aaaa', 'password' => 'aaaaa']);
    }

    public function testLoginReturnUserID()
    {
        $user = new \App\Auth\Entity\User();
        $user->id = rand(0, 1000);
        $user->password = password_hash('aaaaa', PASSWORD_DEFAULT);
        $table = $this->getMockedTable();
        $table->expects($this->once())
            ->method('findByUsername')
            ->willReturn($user);
        $this->assertSame(
            $user,
            $this->getAuth($table)->login(['username' => 'aaaa', 'password' => 'aaaaa'])
        );
        $this->assertSame($user->id, $this->session->get('auth.user'));
    }

    public function testUserNotQueryEveryCall()
    {
        $user = new \App\Auth\Entity\User();
        $user->id = 3;

        $this->session->set('auth.user', $user->id);

        $userTable = $this->getMockedTable();

        $userTable->expects($this->once())
            ->method('find')
            ->willReturn($user);

        $auth = $this->getAuth($userTable);
        $auth->user();
        $auth->user();
    }
}
