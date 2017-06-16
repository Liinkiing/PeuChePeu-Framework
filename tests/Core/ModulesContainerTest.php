<?php

class FakeModule extends \Core\Module {

}

class FakeModuleWithMigration extends \Core\Module {

    public $migrations = 'mig';

}

class FakeModuleWithSeeds extends \Core\Module {

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
        $this->container = new \Core\ModulesContainer(new \Core\App());
    }

    public function testHasWithoutModule () {
        $this->assertEquals(false, $this->container->has('fake'));
    }

    public function testHasWithModule () {
        $this->container->add(new FakeModule());
        $this->assertEquals(true, $this->container->has('FakeModule'));
    }

    public function testGetMigrations () {
        $this->container
            ->add(new FakeModule())
            ->add(new FakeModuleWithMigration())
            ->add(new FakeModuleWithSeeds());
        $this->assertEquals(['mig'], $this->container->getMigrations());
    }

    public function testGetSeeders () {
        $this->container
            ->add(new FakeModule())
            ->add(new FakeModuleWithMigration())
            ->add(new FakeModuleWithSeeds());
        $this->assertEquals(['seed'], $this->container->getSeeders());
    }

}