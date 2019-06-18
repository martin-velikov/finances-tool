<?php

namespace App\Tests\Fixture;

use Doctrine\ORM\EntityManager;
use FactoryGirl\Provider\Doctrine\EntityDef;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class FixtureFactory extends BaseFixtureFactory
{
    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);

        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function addDefinition(FixtureDefinitionInterface $definition)
    {
        $this->defineEntity(
            $definition->getName(),
            $definition->getFieldDefs(),
            $definition->getConfig()
        );
    }

    /**
    * @inheritdoc
    *
    * Improve object construction by calling their constructor and
    * add extension point for custom construction for constructors with dependencies
    */
    public function get($name, array $fieldOverrides = array())
    {
        if (isset($this->singletons[$name])) {
            return $this->singletons[$name];
        }

        $def = $this->entityDefs[$name];
        $config = $def->getConfig();

        $this->checkFieldOverrides($def, $fieldOverrides);

        $fieldValues = array();
        foreach ($def->getFieldDefs() as $fieldName => $fieldDef) {
            if (array_key_exists($fieldName, $fieldOverrides)) {
                $fieldValues[$fieldName] = $fieldOverrides[$fieldName];
                continue;
            }

            $fieldValue = $fieldDef($this);
            if (null !== $fieldValue) {
                $fieldValues[$fieldName] = $fieldValue;
            }
        }

        $ent = $this->createObject($def, $fieldValues);

        foreach ($fieldValues as $fieldName => $fieldValue) {
            $this->setField($ent, $def, $fieldName, $fieldValue);
        }

        if (isset($config['afterCreate'])) {
            $config['afterCreate']($ent, $fieldValues);
        }

        if ($this->persist) {
            $this->em->persist($ent);
        }

        return $ent;
    }

    /**
    * @inheritdoc
    *
    * Original method uses stupid doctrine meta reflection, shunting all getters/setters/adders
    */
    protected function setField($ent, EntityDef $def, $fieldName, $fieldValue)
    {
        // handle private properties with reflection for BC with doctrine embeddable value objects
        if (!$this->accessor->isWritable($ent, $fieldName)) {
            return parent::setField($ent, $def, $fieldName, $fieldValue);
        }

        $metadata = $def->getEntityMetadata();
        if ($metadata->isCollectionValuedAssociation($fieldName)) {
            $this->accessor->setValue($ent, $fieldName, $this->createCollectionFrom($fieldValue));

            return;
        }

        $this->accessor->setValue($ent, $fieldName, $fieldValue);

        if (is_object($fieldValue) && $metadata->isSingleValuedAssociation($fieldName)) {
            $this->updateCollectionSideOfAssocation($ent, $metadata, $fieldName, $fieldValue);
        }
    }

    private function createObject(EntityDef $def, array $fieldValues)
    {
        $config = $def->getConfig();
        $className = $def->getEntityMetadata()->getName();

        if (isset($config['create'])) {
            return $config['create']($fieldValues);
        }

        return new $className();
    }
}
