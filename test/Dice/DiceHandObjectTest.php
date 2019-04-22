<?php

namespace Ame\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Test to se if computer score is insantiated, 0 should be returned
     */
    public function testCreateObjectComputerDiceHand()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Ame\Dice\DiceHand", $dice);

        $res = $dice->getComputerCurrentScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Test to se if player score is insantiated, 0 should be returned
     */
    public function testCreateObjectPlayerDiceHand()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Ame\Dice\DiceHand", $dice);

        $res = $dice->getPlayerCurrentScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Test to se if player score is set to 1
     */
    public function testsetPlayerScore()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Ame\Dice\DiceHand", $dice);

        $dice->setPlayerScore(1);
        $res = $dice->getPlayerCurrentScore();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Test to se if player score is set to 1
     */
    public function testsetComputerScore()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Ame\Dice\DiceHand", $dice);

        $dice->setComputerScore(1);
        $res = $dice->getComputerCurrentScore();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test if 4 values are created
     */
    public function testRoll()
    {
        $dice = new DiceHand();
        //$this->assertInstanceOf("\Ame\Dice\DiceHand", $dice);

        $dice->roll();
        $res = $dice->values();
        $this->assertCount(4, $res);
        //$this->assertLessThan(6, $res[0]]);
    }

    /**
     * Test if values are under 7
     */
    public function testValueOfRoll()
    {
        $dice = new DiceHand();

        $dice->roll();
        $res = $dice->values();
        $this->assertLessThan(7, $res[0]);
        $this->assertLessThan(7, $res[1]);
        $this->assertLessThan(7, $res[2]);
        $this->assertLessThan(7, $res[3]);
    }

    /**
     * Test if 1 is in dice value array if checkroll then returns -1.
     * CheckRoll method should return 0 if 1 is not in dice value array
     */
    public function testCheckRoll()
    {
        $dice = new DiceHand();

        $dice->roll();
        $res = $dice->values();
        $res2 = $dice->checkRoll();

        if (in_array(1, $res)) {
            $this->assertEquals(-1, $res2);
        } else {
            $this->assertEquals(0, $res2);
        }
    }

    /**
     * test sum method
     */
    public function testDiceRollSum()
    {
        $dice = new DiceHand();

        $dice->roll();
        // gets dices value from value method and sums them
        $res = $dice->values();
        $sum = array_sum($res);

        // gets sum value from sum method
        $res2 = $dice->sum();

        // checks if they are equal
        $this->assertEquals($sum, $res2);
    }
}
