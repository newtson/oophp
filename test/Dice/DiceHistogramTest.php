<?php

namespace Ame\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHistogramTest extends TestCase
{
    /**
     * test that correct dice throws are returned
     */
    public function testHistogram()
    {
        $dice = new DiceHand();
        $arr = [1,2,3,4];
        $dice->setHistogramSerie($arr);
        $res = $dice->getHistogramSerie();

        $this->assertEquals($arr, $res);
    }

    public function testHistogramMin()
    {
        $dice = new DiceHand();
        $res = $dice->getHistogramMin();

        $this->assertEquals(1, $res);
    }

    public function testHistogramInt()
    {
        $dice = new DiceHand();
        $hist = new Histogram();
        $arr = [1,2,3,4];
        $hist->injectData($dice, $arr);
        $res = $hist->getSerie();
        $this->assertEquals($arr, $res);
    }

    /**
    * test that dice throw is printed as string
    */
    public function testHistogramgetAsText()
    {
        $dice = new DiceHand();
        $hist = new Histogram();
        $arr = [1,2,3,4,5,6];
        $hist->injectData($dice, $arr);
        $exp = "1: *\n2: *\n3: *\n4: *\n5: *\n6: *";
        $res = $hist->getAsText();
        $this->assertEquals($exp, $res);
    }

    /**
    * test that 0 is returned so computer continues to throw
    */
    public function testcheckComputerContinue()
    {
        $dice = new DiceHand();
        $dice->setPlayerScore(15);
        $dice->setComputerScore(2);
        $res = $dice->checkComputerContinue(5);
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
    * test that 1 is returned so computer does NOT continues to throw
    */
    public function testcheckComputerNotContinue()
    {
        $dice = new DiceHand();
        $dice->setPlayerScore(15);
        $dice->setComputerScore(2);
        $res = $dice->checkComputerContinue(25);
        $exp = 1;
        $this->assertEquals($exp, $res);
    }
}
