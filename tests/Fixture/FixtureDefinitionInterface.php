<?php

 namespace App\Tests\Fixture;

 interface FixtureDefinitionInterface
 {
     public function getName(): string;
     public function getFieldDefs(): array;
     public function getConfig(): array;
 }
