<?php
namespace Math;

use WebService;

class Calculator2
{
    /**
     * @var WebRegisterInterface
     */
    private $register;

    public function __construct(WebService\WebRegister $register)
    {
        $this->register = $register;
    }

    /**
     * This method adds two numbers and returns the result
     * @param number $number1
     * @param number $number2
     * @returns The result of adding the two numbers
     */
    public function add($number1, $number2)
    {
        $result = $number1 + $number2;
        $this->register->send($result);
        return $result;
    }

    /**
     * This method substracts a number from another and returns the result
     * @param number $number1
     * @param number $number2
     * @returns The result of substracting $number2 from $number1
     */
    public function substract($number1, $number2)
    {
        $result = $number1 - $number2;
        $this->register->send($result);
        return $result;
    }

    /**
     * This method multiplies two numbers and returns the result
     * @param number $number1
     * @param number $number2
     * @returns The result of multiplying two numbers
     */
    public function multiply($number1, $number2)
    {
        $result = $number1 * $number2;
        $this->register->send($result);
        return $result;
    }

    /**
     * This method divides one number by another and returns the result
     * @param number $number1
     * @param number $number2
     * @returns The result of dividing $number2 by $number1
     */
    public function divide($number1, $number2)
    {
        if ($number2 == 0) {
            throw new \InvalidArgumentException("Division by zero is not possible");
        }

        $result = $number1 / $number2;
        $this->register->send($result);
        return $result;
    }
}
