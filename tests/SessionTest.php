<?php
class SessionTest extends \PHPUnit\Framework\TestCase {

    public function tearDown()
    {
        session_destroy();
    }

    public function testStart() {
        $this->assertEquals(PHP_SESSION_NONE, session_status());
        $session = new \Core\Session\Session();
        $this->assertEquals(PHP_SESSION_NONE, session_status());
        $username = $session->get('username');
        $this->assertNull($username);
        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
    }

    public function testAlreadyStarted() {
        session_start();
        $session = new \Core\Session\Session();
        $this->assertNotNull($session);
    }

    public function testSetGet() {
        $session = new \Core\Session\Session();
        $session->set('key', 'value');
        $this->assertEquals('value', $session->get('key'));
    }

    public function testDestroy() {
        $session = new \Core\Session\Session();
        $session->set('key', 'value');
        $session->destroy();
        $this->assertEquals(null, $session->get('key'));
    }

}