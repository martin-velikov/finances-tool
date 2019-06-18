<?php

namespace App\Tests\Fixture;

final class ApplyValues
{
    /**
     * Set all $values to $object using setters and adders
     *
     * @param $object
     * @param $values
     */
    public static function process($object, array $values)
    {
        foreach ($values as $key => $value) {
            if (null === $value) {
                continue;
            }

            if (1 < substr_count($key, '.')) {
                self::setSubEmbeddedValue($object, $key, $value);

                continue;
            }

            if (false !== strpos($key, '.')) {
                self::setEmbeddedValue($object, $key, $value);

                continue;
            }

            $setter = 'set' . ucfirst($key);
            if (method_exists($object, $setter)) {
                $object->$setter($value);

                continue;
            }

            $adder = 'add' . ucfirst(rtrim($key, 's'));
            if (is_array($value) && method_exists($object, $adder)) {
                foreach ($value as $item) {
                    $object->$adder($item);
                }
            }
        }
    }

    private static function setEmbeddedValue($object, $path, $value)
    {
        list($embeddedField, $field) = explode('.', $path);

        $getter = 'get' . ucfirst($embeddedField);

        if (method_exists($object, $getter)) {
            $embedded = $object->$getter();
            $setter = 'set' . ucfirst($field);

            if (method_exists($embedded, $setter)) {
                $embedded->$setter($value);
            }
        }
    }

    private static function setSubEmbeddedValue($object, $path, $value)
    {
        $fields = explode('.', $path);
        $getters = [];

        for ($i = 1; $i <= sizeof($fields) - 1; $i++) { 
            $getters[] = 'get' . ucfirst($fields[$i - 1]);
        }

        $embeddedObject = $object;

        foreach ($getters as $getter) {
            if (method_exists($embeddedObject, $getter)) {
                $embeddedObject = $embeddedObject->$getter();
            }
        }

        $setter = 'set' . ucfirst(end($fields));
        if (method_exists($embeddedObject, $setter)) {
            $embeddedObject->$setter($value);
        }
    }
}
