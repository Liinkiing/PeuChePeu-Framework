<?php

class FakeModule {

}

class FakeModuleWithMigration {

    public $migrations = 'mig';

}

class FakeModuleWithSeeds {

    public $seeds = 'seed';

}

class ModulesContainerTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var \Core\ModulesContainer
     */
    private $container;

    /**
     * @before
     */
    public function setupModuleContainer () {
        $this->container = new \Core\ModulesContainer(new \Core\SlimApp());
    }

    public function testHasWithoutModule () {
        $this->assertEquals(false, $this->container->has('fake'));
    }

    public function testHasWithModule () {
        $this->container->add(FakeModule::class);
        $this->assertEquals(true, $this->container->has('FakeModule'));
    }

    public function testGetMigrations () {
        $this->container->add(FakeModule::class);
        $this->container->add(FakeModuleWithMigration::class);
        $this->container->add(FakeModuleWithSeeds::class);
        $this->assertEquals(['mig'], $this->container->getMigrations());
    }

    public function testGetSeeders () {
        $this->container->add(FakeModule::class);
        $this->container->add(FakeModuleWithMigration::class);
        $this->container->add(FakeModuleWithSeeds::class);
        $this->assertEquals(['seed'], $this->container->getSeeders());
    }

}