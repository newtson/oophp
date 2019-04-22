<?php
namespace Ame\Dice;

/**
 *  dice, a class supporting the game. Handling the individual dices
 */
class Dice
{

    private $dice;
    private $sides;

    /**
    * Constructor to dice.
    * @param int $numberSides  amount of sides of dice. Default is 6
    */
    public function __construct(int $numberSides = 6)
    {
        $this->dice = 0;
        $this->sides = $numberSides;
    }

    /**
    *   Throws dice, gets random number between 1 and 6
    *   @return int dice number
    */
    public function throwDice()
    {
        $this->dice = rand(1, 6);

        return $this->dice;
    }
}
