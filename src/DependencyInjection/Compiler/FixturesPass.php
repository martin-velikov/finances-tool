<?php

namespace App\DependencyInjection\Compiler;

use App\Tests\Fixture\FixtureFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FixturesPass implements CompilerPassInterface
{
    const FACTORY_ID = FixtureFactory::class;
    const TAG = 'app.fixture_definition';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::FACTORY_ID)) {
            return;
        }

        $definition = $container->findDefinition(self::FACTORY_ID);
        $taggedServices = $container->findTaggedServiceIds(self::TAG);

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addDefinition', [new Reference($id)]);
        }
    }
}
