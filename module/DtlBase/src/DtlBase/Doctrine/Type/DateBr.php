<?php

namespace DtlBase\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DateBr extends Type {

    const DATEBR = "datebr";

    public function getName() {
        return self::DATEBR;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return $platform->getDateTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if ($value instanceof \DateTime) {
            return $value->format($platform->getDateFormatString());
        }
        if (is_string($value) && (strlen($value) == 10)) {
            $value_array = explode('/', $value);
            if (!empty($value_array) && count($value_array) == 3) {
                $value = $value_array[2] . "-" . $value_array[1] . "-" . $value_array[0];
            }
            $value = new \DateTime($value);
        }
        
//        \Zend\Debug\Debug::dump($value);exit;
        
        return (!empty($value)) ? $value->format($platform->getDateFormatString()) : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {

        if ($value instanceof \DateTime) {
            return date('d/m/Y', $value->getTimestamp());
        }

        if (!is_null($value) && is_string($value)) {
            $val = new \DateTime($value);
            return date('d/m/Y', $val->getTimestamp());
        }

        return $value;
    }

}
