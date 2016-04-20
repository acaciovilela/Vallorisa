<?php

/**
 * Classe de validação de número de CPF
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

class Cpf extends AbstractValidator {
    
    /**
     * Constante de erro referente ao tamanho do número de CPF digitado.
     * 
     */
    const INVALID_SIZE = 'invalidCpfSize';


    /**
     * Constante de erro por dígitos inválidos presentes no número de CPF fornecido.
     *
     */
    const INVALID_DIGIT = 'invalidCpfType';


    /**
     * Constante de erro referente a invalidez do número de CPF fornecido.
     *
     */
    const INVALID_CHECKING = 'invalidChecking';

    /**
     * Variável onde são passados os valores às constantes em forma de mensagens de erro.
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID_SIZE      => "Número de CPF incompleto.",
        self::INVALID_DIGIT     => "O número de CPF digitado contém caracteres inválidos.",
        self::INVALID_CHECKING  => "Número de CPF inválido. Verifique se você digitou o CPF corretamente.",
    );

    /**
     * Método que verifica a validade do CPF.
     * A verificação acontece através dos códigos verificadores (os doi últimos dígitos do CPF).
     *
     * @param string $value
     * @return Boolean
     */
    private function digitChecker($value) {

        /**
         * Verificação do primeiro dígito do CPF
         * 
         */
        $first_digit = substr($value, 9, 1);
        $second_digit = substr($value, 10, 1);

        $value_array = str_split(substr($value, 0, 9));

        $count = 0;
        $soma = 0;

        for ($i = 10; $i > 1; $i--) {
            $soma += $value_array[$count] * $i;
            $count++;
        }

        $value_module = ($soma % 11);

        if ($value_module < 2) {
            $new_value = "0";
        } else {
            $new_value = 11 - $value_module;
        }

        if ($new_value != $first_digit) {
            return false;
        }

        /**
         * Verificação do segundo dígito do CPF.
         * 
         * Levando em conta que a houve êxito na validação do primeiro dígito do CPF.
         * 
         */
        array_push($value_array, $new_value);

        $count = 0;
        $soma = 0;

        for ($i = 11; $i > 1; $i--) {
            $soma += $value_array[$count] * $i;
            $count++;
        }

        $value_module = ($soma % 11);

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

    /**
     * Método que controla todas as verificações desenvolvidas acima
     *
     * @param string $value
     * @return Boolean | String Message
     */
    public function isValid($value) {

        $this->setValue($value);

        if (!is_numeric($value)) {
            $this->error(self::INVALID_DIGIT);
            return false;
        }

        if (strlen($value) != 11) {
            $this->error(self::INVALID_SIZE);
            return false;
        }

        $digit_checking = $this->digitChecker($value);

        if (!$digit_checking) {
            $this->error(self::INVALID_CHECKING);
            return false;
        }

        return true;
    }
}
