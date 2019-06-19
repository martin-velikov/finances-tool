<?php

namespace App\Tests\Fixture\Definition;

use App\Entity\User;
use App\Tests\Fixture\ApplyValues;
use App\Tests\Fixture\FixtureDefinitionInterface;
use FactoryGirl\Provider\Doctrine\FieldDef;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtureDefinition implements FixtureDefinitionInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function getName(): string
    {
        return User::class;
    }

    public function getFieldDefs(): array
    {
        return [
            'username' => FieldDef::sequence('user%d'),
            'password' => '123qwe',
            'name' => FieldDef::sequence('Name %d'),
            'phone' => FieldDef::sequence('0888888888'),
            'email' => FieldDef::sequence('user%d@mail.com'),
            'roles' => ['ROLE_USER'],
        ];
    }

    public function getConfig(): array
    {
        return [
            'afterCreate' => function(User $user, array $values) {
                ApplyValues::process($user, $values);
                $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
            },
        ];
    }
}
