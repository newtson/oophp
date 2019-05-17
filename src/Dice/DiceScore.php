<?php
namespace Ame\Dice;

/**
 *  dicescore, a class supporting the game. Handles the players score.
 */
class DiceScore
{
    /**
     * @var int $computer score   consisting of scores for computer.
     * @var int  $player  consisting of score for player.
     */
    private $computer;
    private $player;

    /**
     * Constructor to initiate the game with scores
     *
     */
    public function __construct()
    {
        $this->computer  = 0;
        $this->player = 0;
    }

    /**
    * add and saves score to player
    * @param int score to add and save.
    */
    public function saveScorePlayer(int $score)
    {
        $this->player = $this->player + $score;
    }

    /**
    * Get player current score
    * @return int player score
    */
    public function getScorePlayer()
    {
        return $this->player;
    }

    /**
    * add and saves score to computer
    * @param int score to add and save.
    */
    public function saveScoreComputer(int $score)
    {
        $this->computer = $this->computer + $score;
    }

    /**
    * Get computer current score
    * @return int computer score
    */
    public function getScoreComputer()
    {
        return $this->computer;
    }
}
