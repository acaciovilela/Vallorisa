<?php

/**
 * Classe de validação de número de CNPJ
 * 
 * @author 	Acácio Vilela <acaciovilela@gmail.com>
 * @abstract 	Zend\Validator\AbstractValidator
 * @category 	Validator
 * @copyright   Techno Center Informatica
 * @license 	Private
 * @package 	DtlBase/Validator
 * @version 	2.0
 * @since 	January, 2013
 * 
 */
namespace DtlBase\Validator;

use Zend\Validator\AbstractValidator;

class Cnpj extends AbstractValidator {

    const INVALID_SIZE      = "invalidSize";
    const INVALID_TYPE      = "invalidType";
    const INVALID_DIGITS    = "invalidDigits";
    const INVALID_EMPTY     = "invalidEmpty";

    protected $messageTemplates = array(
        self::INVALID_SIZE      => "O CNPJ '%value%' digitado está incompleto.",
        self::INVALID_TYPE      => "O CNPJ '%value%' digitado contém dígitos inválidos.",
        self::INVALID_DIGITS    => "O CNPJ '%value%' digitado é inválido.",
        self::INVALID_EMPTY     => "O campo de CNPJ está em branco. Este campo deve ser preenchido."
    );

    private function cnpjCheker($value) {
        $first_digit = substr($value, 12, 1);
        $second_digit = substr($value, 13, 1);

        $value_array = str_split(substr($value, 0, 12));

        $increase = 10;
        $count = 0;
        $soma = 0;
        $true = false;

        if (count($value_array) != 12) {
            return false;
        } else {
            for ($i = 5; $i > 1; $i--) {
                $soma += $value_array[$count] * $i;
                $count++;
                if ($i == 2) {
                    if ($true) {
                        continue;
                    }
                    $i = $increase;
                    $true = true;
                }
            }
        }

        $value_module = $soma % 11;

        if ($value_module < 2) {
            $new_value = "0";
        } else {
            $new_value = 11 - $value_module;
        }

        if ($new_value != $first_digit) {
            return false;
        }
        /**
         * Verificação do Segundo dígito verificador
         */
        array_push($value_array, $new_value);

        $increase = 10;
        $count = 0;
        $soma = 0;
        $true = false;

        if (count($value_array) != 13) {
            return false;
        } else {
            for ($i = 6; $i > 1; $i--) {
                $soma += $value_array[$count] * $i;
                $count++;
                if ($i == 2) {
                    if ($true) {
                        continue;
                    }
                    $i = $increase;
                    $true = true;
                }
            }
        }

        $value_module = $soma % 11;

        if ($value_module < 2) {
            $new_value = "0";
        } else {
            $new_value = 11 - $value_module;
        }

        if ($new_value != $second_digit) {
            return false;
        }

        return true;
    }

    public function isValid($value) {
        $filter = new \Zend\Filter\Digits();
        
        $value = $filter->filter($value);
        
        $this->setValue($value);

        if (empty($value)) {
            $this->error(self::INVALID_EMPTY);
            return false;
        }

        if (!is_numeric($value)) {
            $this->error(self::INVALID_TYPE);
            return false;
        }

        if (strlen($value) != 14) {
            $this->error(self::INVALID_SIZE);
            return false;
        }

        $checking = $this->cnpjCheker($value);

        if (!$checking) {
            $this->error(self::INVALID_DIGITS);
            return false;
        }

        return true;
    }
}
