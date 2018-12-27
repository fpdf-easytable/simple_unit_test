<?php
namespace Abc\Def\Ghi;
 
interface NumberInterface
{
    /**
     * Adds n to this number
     * 
     * @param int $n The amount to add to this number
     * @return int The new integer value of this number
     * @throws \InvalidArgumentException Thrown if $n is not an integer
     */
    public function add($n);
    
    /**
     * Subtracts n from this number
     * 
     * @param int $n The amount to subtract from this number
     * @return int The new integer value of this number
     * @throws \InvalidArgumentException Thrown if $n is not an integer
     */
    public function subtract($n);
    
    /**
     * Multiplies this number by n
     * 
     * @param int $n The amount to multiply this number by
     * @return int The new integer value of this number
     * @throws \InvalidArgumentException Thrown if $n is not an integer
     */
    public function multiply($n);
    
    /**
     * Divides this number by n
     * 
     * @param int $n The amount to divide this number by
     * @return int The new integer value of this number
     * @throws \InvalidArgumentException Thrown if $n is zero or not an integer
     */
    public function divide($n);
    
    /**
     * Returns the integer value of this number
     * 
     * @return int The current integer value of this number
     */
    public function toInt();
}