<?php

namespace Ame\Dice;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $arrOne = [];
        $arrTwo = [];
        $arrThree = [];
        $arrFour = [];
        $arrFive = [];
        $arrSix = [];

        for ($i = 0; $i < sizeof($this->serie); $i++) {
            if ($this->serie[$i] == 1) {
                array_push($arrOne, "*");
            } else if ($this->serie[$i] == 2) {
                array_push($arrTwo, "*");
            } else if ($this->serie[$i] == 3) {
                array_push($arrThree, "*");
            } else if ($this->serie[$i] == 4) {
                array_push($arrFour, "*");
            } else if ($this->serie[$i] == 5) {
                array_push($arrFive, "*");
            } if ($this->serie[$i] == 6) {
                array_push($arrSix, "*");
            }
        }

        return $this->printAll($arrOne, $arrTwo, $arrThree, $arrFour, $arrFive, $arrSix);
    }

    /**
    * makes a string out of the arrays
    * @param array $arrOne, $arrTwo, $arrThree, $arrFour, $arrFive, $arrSix
    * contains * representing amount of times dice number shown
    * @return string representing the histogram.
    */
    public function printAll($arrOne, $arrTwo, $arrThree, $arrFour, $arrFive, $arrSix)
    {
        $str = "";
        $str = "1: ";
        for ($j = 0; $j < sizeof($arrOne); $j++) {
            $str .= $arrOne[$j];
        }
        $str .= "\n";
        $str .= "2: ";
        for ($k = 0; $k < sizeof($arrTwo); $k++) {
            $str .= $arrTwo[$k];
        }
        $str .= "\n";
        $str .= "3: ";
        for ($l = 0; $l < sizeof($arrThree); $l++) {
            $str .= $arrThree[$l];
        }
        $str .= "\n";
        $str .= "4: ";
        for ($m = 0; $m < sizeof($arrFour); $m++) {
            $str .= $arrFour[$m];
        }
        $str .= "\n";
        $str .= "5: ";
        for ($n = 0; $n < sizeof($arrFive); $n++) {
            $str .= $arrFive[$n];
        }
        $str .= "\n";
        $str .= "6: ";
        for ($o = 0; $o < sizeof($arrSix); $o++) {
            $str .= $arrSix[$o];
        }

        return $str;
    }


    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object, $arr)
    {
        $object->setHistogramSerie($arr);

        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
