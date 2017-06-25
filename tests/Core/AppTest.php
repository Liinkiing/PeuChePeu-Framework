<?php

class FakeModule extends \Core\Module {

    public const DEFINITIONS = [
        'a' => 'b'
    ];

}

class AppTest extends \PHPUnit\Framework\TestCase {

    public function testDefinitions () {
        $app = new \Core\App([], [FakeModule::class]);
        $this->assertEquals('b', $app->getContainer()->get('a'));
    }

    public function testGetModule () {
        $app = new \Core\App([], [FakeModule::class]);
        $this->assertEquals([FakeModule::class], $app->getModules());
    }

}