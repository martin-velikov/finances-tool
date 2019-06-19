<?php

namespace App\Tests;

use App\Tests\Fixture\FixtureFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;

abstract class DatabaseWebTestCase extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->generateSchema();
        $this->prepareFixtures();
    }

    protected function getManager(): EntityManager
    {
        return static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    private function generateSchema()
    {
        $metadata = $this->getManager()->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $tool = new SchemaTool($this->getManager());
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
    }

    protected function prepareFixtures()
    {
        $factory = static::$kernel->getContainer()->get(FixtureFactory::class);
        $this->setUpFixtures($factory);
        $this->getManager()->flush();
    }

    abstract protected function setUpFixtures(BaseFixtureFactory $factory);
}
