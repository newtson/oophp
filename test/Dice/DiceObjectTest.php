<?php

namespace Ame\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceScore.
 */
class DiceObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Test to se if 1 is added to players score if then 1 is returned in get method
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new DiceScore();
        $this->assertInstanceOf("\Ame\Dice\DiceScore", $dice);

        $dice->saveScorePlayer(1);
        $res = $dice->getScorePlayer();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Test to se if 1 is added to computer score if then 1 is returned in get method
     */
    public function testCreateComputerScore()
    {
        $dice = new DiceScore();
        $this->assertInstanceOf("\Ame\Dice\DiceScore", $dice);

        $dice->saveScoreComputer(1);
        $res = $dice->getScoreComputer();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }
}
