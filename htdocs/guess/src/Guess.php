<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    private $tries;


    /**
     * Constructor to create a guessgame.
     *
     * constructor set tries to 6
     */
    public function __construct()
    {
        $this->number = 0;
        $this->tries = 6;
    }


    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random()
    {
        $this->number = rand(1, 100);
    }


    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries() : int
    {
        return $this->tries;
    }


    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number() : int
    {
        return $this->number;
    }


    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     * @param int the number user guessed
     * @return string to show the status of the guess made.
     */
    public function makeGuess(int $guess) : string
    {
        /* checks if guess right/too low/too high/out of bounds/out of guesses */
        if ($this->tries <= 0) {
            $res = "You have no guesses left";
        } elseif ($guess == $this->number) {
            $res = "Correct";
            /* decrease remaining guess */
            $this->tries = $this->tries - 1;
        } elseif ($guess > 100 || $guess < 1) {
            /* decrease remaining guess */
            $this->tries = $this->tries - 1;
            throw new GuessException("Guess a number between 1 and 100.");
        } elseif ($guess < $this->number) {
            $res = "It is too low";
            /* decrease remaining guess */
            $this->tries = $this->tries - 1;
        } else {
            $res = "It is too high";
            /* decrease remaining guess */
            $this->tries = $this->tries - 1;
        }

        return $res;
    }
}
