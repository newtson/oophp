<?php
namespace Ame\Dice;

/**
 *  dicehand, a class supporting the game. Handles the combined dices
 */
class DiceHand
{


    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     * @var DiceScore $playerScore int contains players score
     * @var DiceScore $computerScore int contains computers score
     */
    private $dices;
    private $values;
    private $playerScore;
    private $computerScore;

    /**
     * Constructor to initiate the dicehand with a number of dices
     * and initiate score
     * @param int $dices Number of dices to create, defaults to four.
     */
    public function __construct(int $dices = 4)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
        }

        $this->playerScore = new DiceScore();
        $this->computerScore = new DiceScore();
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
        $len = count($this->dices);
        for ($i = 0; $i < $len; $i++) {
            // lägger in värden för alla dice objekt i values array
            $this->values[$i]  = $this->dices[$i]->throwDice();
        }
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    /**
     * checks if 1 is in the rolls
     *
     * @return int -1 if 1 is in roll, 0 if not in roll
     */
    public function checkRoll()
    {
        $res = 0;
        $len = count($this->values);
        // loops through values of dices
        for ($i = 0; $i < $len; $i++) {
            // looks too see if 1 is amoung values
            if ($this->values[$i]  == 1) {
                // if 1 is found $res value is set to -1
                $res = -1;
            }
        }
        return $res;
    }

    /**
     * set score for player
     * @param int score contains amount to saved to players score
     */
    public function setPlayerScore(int $score)
    {
        $this->playerScore->saveScorePlayer($score);
    }

    /**
     * set score for computer
     * @param int score contains amount to saved to computers score
     */
    public function setComputerScore(int $score)
    {
        $this->computerScore->saveScoreComputer($score);
    }

    /**
     * gets computer current score
     * @return int current score for computer
     */
    public function getComputerCurrentScore()
    {
        return $this->computerScore->getScoreComputer();
    }

    /**
     * gets player current score
     * @return int current score for player
     */
    public function getPlayerCurrentScore()
    {
        return $this->playerScore->getScorePlayer();
    }

    /**
    * Get the sum of all dices in current roll.
    * @return int as the sum of all dices values.
    */
    public function sum()
    {
        $sum = 0;
        $len = count($this->dices);
        for ($x = 0; $x < $len; $x++) {
            $sum = $sum + $this->values[$x];
        }
        return $sum;
    }
}
