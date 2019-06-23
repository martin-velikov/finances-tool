<?php

namespace App\Tests\Fixture\Definition;

use App\Entity\Rates;
use App\Tests\Fixture\FixtureDefinitionInterface;
use FactoryGirl\Provider\Doctrine\FieldDef;

class RatesFixtureDefinition implements FixtureDefinitionInterface
{

    public function getName(): string
    {
        return Rates::class;
    }

    public function getFieldDefs(): array
    {
        return [
            'id' => FieldDef::sequence('%d'),
            'rates' => [],
        ];
    }

    public function getConfig(): array
    {
        return [];
    }
}
